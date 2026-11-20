<?php

declare(strict_types=1);

namespace GhostCrawl\Tests;

use GhostCrawl\GhostCrawlClient;
use GhostCrawl\APIError;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

/**
 * Guards the SHIP-BLOCKER reliability fix: the underlying Guzzle transport MUST
 * carry finite connect/read timeouts. Guzzle's own default is 0 = wait forever,
 * which hangs the caller on a stalled socket or dead proxy. These tests prove the
 * timeouts are actually wired onto the constructed HTTP client (default + custom)
 * and that a request to a dead endpoint fails fast instead of hanging.
 */
final class HttpTimeoutTest extends TestCase
{
    /**
     * Reflect into the client → Kiota adapter → Guzzle client → its config array.
     *
     * @return array<string, mixed>
     */
    private function guzzleConfig(GhostCrawlClient $client): array
    {
        $adapter = $this->readPrivate($client, 'adapter');
        self::assertInstanceOf(GuzzleRequestAdapter::class, $adapter);
        $guzzle = $this->readPrivate($adapter, 'guzzleClient');
        self::assertInstanceOf(GuzzleClient::class, $guzzle);
        $config = $this->readPrivate($guzzle, 'config');
        self::assertIsArray($config);
        return $config;
    }

    private function readPrivate(object $obj, string $prop): mixed
    {
        $ref = new ReflectionObject($obj);
        $p = $ref->getProperty($prop);
        $p->setAccessible(true);
        return $p->getValue($obj);
    }

    public function testDefaultTimeoutsAreWiredOntoTheTransport(): void
    {
        $client = new GhostCrawlClient('gck_test_key');
        $config = $this->guzzleConfig($client);

        self::assertSame(
            GhostCrawlClient::DEFAULT_CONNECT_TIMEOUT_SECONDS,
            $config[RequestOptions::CONNECT_TIMEOUT] ?? null,
            'default connect_timeout must be finite (never 0 = wait forever)'
        );
        self::assertSame(
            GhostCrawlClient::DEFAULT_TIMEOUT_SECONDS,
            $config[RequestOptions::TIMEOUT] ?? null,
            'default timeout must be finite (never 0 = wait forever)'
        );
        // A finite, non-zero bound is the whole point.
        self::assertGreaterThan(0, $config[RequestOptions::CONNECT_TIMEOUT]);
        self::assertGreaterThan(0, $config[RequestOptions::TIMEOUT]);
    }

    public function testCustomTimeoutsOverrideTheDefaults(): void
    {
        $client = new GhostCrawlClient('gck_test_key', null, 42.0, 7.0);
        $config = $this->guzzleConfig($client);

        self::assertSame(7.0, $config[RequestOptions::CONNECT_TIMEOUT]);
        self::assertSame(42.0, $config[RequestOptions::TIMEOUT]);
    }

    public function testRequestToDeadPortFailsFastInsteadOfHanging(): void
    {
        // 127.0.0.1:1 is a closed port — connection is refused (fast). The point
        // is that the call RETURNS (mapped to a typed SDK error) rather than
        // hanging forever, and does so well within a tiny connect timeout.
        $client = new GhostCrawlClient('gck_test_key', 'http://127.0.0.1:1', 2.0, 1.0);

        $start = microtime(true);
        try {
            $client->me();
            self::fail('expected a transport failure against a dead port');
        } catch (APIError $e) {
            // Connection refused / unreachable is normalized to APIError (status 0).
            self::assertSame(0, $e->statusCode);
        }
        $elapsed = microtime(true) - $start;
        self::assertLessThan(5.0, $elapsed, 'a dead endpoint must fail fast, not hang');
    }
}
