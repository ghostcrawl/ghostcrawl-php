<?php

declare(strict_types=1);

namespace GhostCrawl\Tests;

use GhostCrawl\BinaryResult;
use GhostCrawl\CrawlRun;
use GhostCrawl\Document;
use GhostCrawl\GhostCrawlError;
use GhostCrawl\ScrapeResult;
use GhostCrawl\SearchResult;
use GhostCrawl\SearchPoll;
use PHPUnit\Framework\TestCase;

/**
 * Unit-tests the typed-but-array-accessible result models and the 
 * search(wait) bounded client-side poll — with no transport (the poll's only
 * I/O is an injected getter, mirroring CrawlRunWaitTest's fetchWaiting seam).
 */
final class TypedResultsAndSearchWaitTest extends TestCase
{
    // -- typed properties AND ['key'] back-compat ---------------------

    public function testScrapeResultTypedAndArrayAccessAgree(): void
    {
        $r = new ScrapeResult([
            'status'      => 'ok',
            'markdown'    => '# Hello',
            'status_code' => 200,
            'bytes'       => 7,
            'url'         => 'https://example.com',
            'format'      => 'markdown',
            'warnings'    => [],
        ]);

        // Canonical typed property access.
        self::assertSame('# Hello', $r->markdown);
        // Identical value via ['key'] back-compat.
        self::assertSame('# Hello', $r['markdown']);
        // content is surfaced from the format-specific rendered field.
        self::assertSame('# Hello', $r->content);
        self::assertSame('# Hello', $r['content']);
        self::assertSame(200, $r->status_code);
        self::assertSame(200, $r['status_code']);
        self::assertSame(7, $r->bytes);
        self::assertSame('markdown', $r->format);
        self::assertSame([], $r->warnings);
    }

    public function testScrapeResultIsArrayAccessibleAndIterable(): void
    {
        $r = new ScrapeResult(['status' => 'ok', 'markdown' => 'x', 'extra_server_field' => 42]);

        self::assertInstanceOf(\ArrayAccess::class, $r);
        self::assertInstanceOf(\IteratorAggregate::class, $r);
        // Undeclared / extra server fields survive via array access (never lost).
        self::assertSame(42, $r['extra_server_field']);
        self::assertTrue(isset($r['status']));
        self::assertFalse(isset($r['nope']));
        // Iterable over the underlying payload.
        $keys = array_keys(iterator_to_array($r));
        self::assertContains('extra_server_field', $keys);
        // toArray() returns the complete decoded response.
        self::assertArrayHasKey('content', $r->toArray());
    }

    public function testSearchResultTypedAndArrayAccess(): void
    {
        $r = new SearchResult(['status' => 'ok', 'query' => 'books', 'results' => [['title' => 'A']]]);
        self::assertSame('books', $r->query);
        self::assertSame('books', $r['query']);
        self::assertSame([['title' => 'A']], $r->results);
        self::assertCount(1, $r->results);
    }

    public function testRunningHandleHasStableShape(): void
    {
        // A timed-out running handle ({status:"running", job_id}) has no items/results;
        // results must be a non-null empty array by BOTH property- and array-access.
        $r = new SearchResult(['status' => 'running', 'job_id' => 'x']);
        self::assertSame([], $r->results);
        self::assertSame([], $r['results']);
        self::assertSame('running', $r->status);
        self::assertNull($r->query);
    }

    public function testCrawlRunTypedAndArrayAccess(): void
    {
        $r = new CrawlRun(['run_id' => 'run_abc', 'status' => 'completed', 'results' => [1, 2]]);
        self::assertSame('run_abc', $r->run_id);
        self::assertSame('run_abc', $r['run_id']);
        self::assertSame('completed', $r->status);
    }

    public function testDocumentAndBinaryResultCanonicalFields(): void
    {
        $doc = new Document(['title' => 'T', 'url' => 'https://e.com', 'content' => 'body']);
        self::assertSame('T', $doc->title);
        self::assertSame('body', $doc['content']);

        $bin = new BinaryResult('PDFBYTES', 'application/pdf');
        self::assertSame('PDFBYTES', $bin->bytes);
        self::assertSame('application/pdf', $bin->content_type);
        self::assertSame('application/pdf', $bin['content_type']);
    }

    // -- search(wait) bounded client-side poll -----------------------

    public function testWarmPathReturnsImmediatelyWithNoPollUrl(): void
    {
        $calls = 0;
        $get = function () use (&$calls) { $calls++; return [200, [], []]; };

        $job = ['status' => 'completed', 'results' => [1]];
        $out = SearchPoll::pollSearchJob($job, 'https://api.ghostcrawl.io', $get);

        self::assertSame($job, $out, 'no poll_url => nothing to poll (warm path)');
        self::assertSame(0, $calls, 'warm path never issues a poll GET');
    }

    public function testColdPathPolls202ThenTerminal200(): void
    {
        $responses = [
            [202, ['Retry-After' => '0'], ['status' => 'running']],
            [200, [], ['status' => 'completed', 'results' => [['title' => 'A']]]],
        ];
        $calls = 0;
        $get = function (string $url) use (&$responses, &$calls) {
            $calls++;
            return array_shift($responses);
        };
        $slept = [];
        // Nonzero initial delay so the first inter-poll wait is observably routed
        // through the injected sleeper (no real time spent).
        $sleeper = function (float $s) use (&$slept) { $slept[] = $s; };

        $job = ['status' => 'running', 'poll_url' => '/v1/search/jobs/job_123', 'poll_max_seconds' => 30];
        $out = SearchPoll::pollSearchJob($job, 'https://api.ghostcrawl.io', $get, null, 1.5, $sleeper);

        self::assertSame('completed', $out['status']);
        self::assertSame([['title' => 'A']], $out['results']);
        self::assertSame(2, $calls, '202 running then a terminal 200 = two poll GETs');
        // The inter-poll delay is routed through the injected sleeper (bounded,
        // deterministic — no real wall-clock time spent).
        self::assertSame([1.5], $slept, 'first inter-poll delay honours the initial Retry-After');
    }

    public function testColdPathTerminalStatusBodyIsDone(): void
    {
        $get = fn (string $url) => [202, [], ['status' => 'failed']];
        $job = ['status' => 'running', 'poll_url' => 'https://api.ghostcrawl.io/v1/search/jobs/j'];
        $out = SearchPoll::pollSearchJob($job, 'https://api.ghostcrawl.io', $get, null, 0.0, fn () => null);
        // A terminal-status body (even under a 202) is returned as a value (no throw).
        self::assertSame('failed', $out['status']);
    }

    public function testPollDeadlineReturnsLatestNonTerminalWithoutThrowing(): void
    {
        $get = fn (string $url) => [202, [], ['status' => 'running', 'progress' => 1]];
        $job = ['status' => 'running', 'poll_url' => '/v1/search/jobs/j'];

        $start = microtime(true);
        // 1s budget, injected sleeper advances nothing → bounded by the deadline.
        $out = SearchPoll::pollSearchJob($job, 'https://api.ghostcrawl.io', $get, 1, 0.0, fn () => null);
        $elapsed = microtime(true) - $start;

        self::assertSame('running', $out['status'], 'timeout yields the latest non-terminal record');
        self::assertLessThan(3.0, $elapsed, 'the wait is bounded by the caller deadline');
    }

    public function testPoll404IsTerminalAndRaisesTypedError(): void
    {
        $get = fn (string $url) => [404, [], ['code' => 'not_found']];
        $job = ['status' => 'running', 'poll_url' => '/v1/search/jobs/gone'];

        $this->expectException(GhostCrawlError::class);
        SearchPoll::pollSearchJob($job, 'https://api.ghostcrawl.io', $get, null, 0.0, fn () => null);
    }

    public function testRetryAfterParsingAndUrlResolution(): void
    {
        self::assertSame(2.5, SearchPoll::parseRetryAfter('2.5'));
        self::assertNull(SearchPoll::parseRetryAfter('soon'));
        self::assertNull(SearchPoll::parseRetryAfter(null));
        self::assertNull(SearchPoll::parseRetryAfter('-1'));

        self::assertSame(
            'https://api.ghostcrawl.io/v1/search/jobs/j',
            SearchPoll::resolveUrl('https://api.ghostcrawl.io/', '/v1/search/jobs/j'),
        );
        self::assertSame(
            'https://other.example/x',
            SearchPoll::resolveUrl('https://api.ghostcrawl.io', 'https://other.example/x'),
        );
    }
}
