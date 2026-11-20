<?php

declare(strict_types=1);

namespace GhostCrawl\Tests;

use GhostCrawl\CrawlRunsClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Unit-tests the event-driven crawl-run completion wait
 * ({@see CrawlRunsClient::waitForCompletion()}).
 *
 * The wait loop's only I/O is the {@see CrawlRunsClient::fetchWaiting()} network
 * seam (the long-polling `GET .../{run_id}?wait=true&timeout_s=N`). These tests
 * override that seam with scripted responses so the loop — terminal detection,
 * window capping, deadline handling — is exercised without any transport or a
 * live V1 request builder.
 */
final class CrawlRunWaitTest extends TestCase
{
    /**
     * Build a scripted CrawlRunsClient without invoking the real constructor
     * (which needs a Kiota V1 builder + base URL). The wait loop touches neither.
     */
    private function scriptedClient(array $responses): ScriptedCrawlRuns
    {
        $client = (new ReflectionClass(ScriptedCrawlRuns::class))->newInstanceWithoutConstructor();
        $client->scripted = $responses;
        return $client;
    }

    public function testReturnsImmediatelyWhenAlreadyTerminal(): void
    {
        $client = $this->scriptedClient([['status' => 'completed', 'results' => [1, 2]]]);

        $run = $client->waitForCompletion('run_abc', 300);

        self::assertSame('completed', $run['status']);
        self::assertSame(1, $client->calls, 'a terminal run resolves in a single long-poll window');
    }

    public function testReArmsAcrossNonTerminalWindowsUntilTerminal(): void
    {
        $client = $this->scriptedClient([
            ['status' => 'running'],
            ['status' => 'running'],
            ['status' => 'failed'],
        ]);

        $run = $client->waitForCompletion('run_abc', 300);

        // A terminal failed/cancelled run is returned as a value (no throw).
        self::assertSame('failed', $run['status']);
        self::assertSame(3, $client->calls, 're-arms one window per non-terminal poll');
    }

    public function testUsSpellingCanceledIsTerminal(): void
    {
        $client = $this->scriptedClient([['status' => 'canceled']]);

        $run = $client->waitForCompletion('run_abc', 10);

        self::assertSame('canceled', $run['status']);
        self::assertSame(1, $client->calls);
    }

    public function testDeadlineReturnsLastNonTerminalRunWithoutThrowing(): void
    {
        $client = $this->scriptedClient([['status' => 'running']]);
        $client->blockWindow = true; // emulate the server holding the request open

        $start = microtime(true);
        $run = $client->waitForCompletion('run_abc', 1, 1); // 1s deadline, 1s window
        $elapsed = microtime(true) - $start;

        self::assertSame('running', $run['status'], 'timeout yields the current non-terminal run');
        self::assertLessThan(2.0, $elapsed, 'the wait is bounded by the caller deadline');
        self::assertGreaterThanOrEqual(1, $client->calls);
    }

    public function testEachWindowIsCappedToThePollWindow(): void
    {
        $client = $this->scriptedClient([
            ['status' => 'running'],
            ['status' => 'completed'],
        ]);

        $client->waitForCompletion('run_abc', 300, 30);

        self::assertNotEmpty($client->windows);
        foreach ($client->windows as $window) {
            self::assertLessThanOrEqual(30, $window, 'no window exceeds the pollWindow cap');
            self::assertGreaterThanOrEqual(1, $window, 'timeout_s is always at least 1 second');
        }
    }

    public function testEachWindowIsCappedToTheRemainingBudget(): void
    {
        $client = $this->scriptedClient([['status' => 'completed']]);

        // pollWindow (300) far exceeds the deadline (5) — the first window must be
        // capped to the remaining budget so the block never over-runs the caller.
        $client->waitForCompletion('run_abc', 5);

        self::assertSame(1, $client->calls);
        self::assertLessThanOrEqual(5, $client->windows[0]);
    }
}

/**
 * Test double: overrides the network seam with scripted responses and records
 * the `timeout_s` window each long-poll iteration armed.
 */
final class ScriptedCrawlRuns extends CrawlRunsClient
{
    /** @var list<array<string,mixed>> */
    public array $scripted = [];
    public int $calls = 0;
    public bool $blockWindow = false;
    /** @var list<int> */
    public array $windows = [];

    protected function fetchWaiting(string $runId, int $timeoutS): array
    {
        $this->windows[] = $timeoutS;
        $this->calls++;
        if ($this->blockWindow) {
            usleep((int) ($timeoutS * 1_000_000)); // emulate the server-side block
        }
        return array_shift($this->scripted) ?? ['status' => 'running'];
    }
}
