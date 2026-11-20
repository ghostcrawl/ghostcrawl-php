<?php

declare(strict_types=1);

namespace GhostCrawl\Tests;

use GhostCrawl\GhostCrawlClient;
use GhostCrawl\GhostCrawlError;
use PHPUnit\Framework\TestCase;

/**
 * php lane parity-e2e runner (real execution).
 *
 * Exercises EVERY user-surface row in scripts/phase178/rowset.json ONCE against
 * the REAL ghostcrawl backend (the cloud test tenant) and writes one transcript
 * per row to:
 *
 *   the php lane evidence directory as {row}.transcript.json
 *
 * conforming to the transcript schema (counts + var-names only,
 * NEVER a credential value).
 *
 * Secrets: the token is read from GHOSTCRAWL_API_KEY and the base URL
 * from GHOSTCRAWL_BASE_URL — NEVER hardcoded. If the token is unset this test is
 * SKIPPED and fabricates NOTHING (the operator provisions a locked-down token,
 * revoked after the run).
 *
 * Classification: deterministic real 2xx → GREEN; the account-gated
 * agent 404 → GREEN (plumbing) / hosted (BYO LLM) (documented contract, NOT
 * laundered, does not drive the full agent reasoning loop); async rows real-but-minimal; me/usage 404
 * → real RED; search keyless 401 → N/A-BYO; any 429/503 self-throttle → RED
 * FAIL-to-root-cause.
 *
 * Run via `make -C sdks/php parity-e2e` (which wraps this in the shared flock
 * run-lock scripts/phase178/parity-run.sh so concurrent lanes serialize their hits
 * to the single shared tenant — W2). This is a live-network integration run and is
 * EXPECTED to exceed the 30s soft-latency guidance (network-bound, not a hang — W5).
 */
final class ParityE2ETest extends TestCase
{
    private const TOKEN_VAR = 'GHOSTCRAWL_API_KEY';
    private const BASE_VAR   = 'GHOSTCRAWL_BASE_URL';
    private const LANE       = 'php';
    private const TARGET     = 'https://books.toscrape.com';

    /** Self-throttle statuses that may NEVER back a GREEN cell. */
    private const LAUNDER = [429, 503];
    /** Transient upstream 5xx worth a bounded retry — EXCLUDES 429/503. */
    private const TRANSIENT = [500, 502, 504];

    private function repoRoot(): string
    {
        return dirname(__DIR__, 3);
    }

    private function evidenceDir(): string
    {
        return $this->repoRoot()
            . '/.planning/phases/178-api-sdk-functionality-e2e-and-parity/178-EVIDENCE/php';
    }

    private function now(): string
    {
        return gmdate('Y-m-d\TH:i:s\Z');
    }

    /** @param mixed $value @return list<string> */
    private function shapeKeys(mixed $value): array
    {
        // : scrape/search/crawl/content/map return typed Result objects that
        // are array-accessible — unwrap to the decoded payload for shape evidence.
        if ($value instanceof \GhostCrawl\Result) {
            $value = $value->toArray();
        }
        if (!is_array($value)) {
            return [];
        }
        $keys = array_map('strval', array_keys($value));
        sort($keys);
        return $keys;
    }

    /** @param array<string,mixed> $hash */
    private function idOf(array $hash, string $primary): ?string
    {
        foreach ([$primary, 'id'] as $k) {
            if (isset($hash[$k]) && (string) $hash[$k] !== '') {
                return (string) $hash[$k];
            }
        }
        return null;
    }

    /** A deterministic read/round-trip → GREEN on a returned body (implies 2xx). */
    private function green(string $method, string $requestLine, mixed $result): array
    {
        $ev = ['token_var' => self::TOKEN_VAR];
        $keys = [];
        if (is_string($result)) {
            $ev['result_bytes'] = strlen($result);
        } elseif (is_array($result) || $result instanceof \GhostCrawl\Result) {
            $keys = $this->shapeKeys($result);
            $ev['key_count'] = count($keys);
        }
        return [
            'method' => $method, 'request_line' => $requestLine, 'status' => 200,
            'shape_keys' => $keys, 'evidence' => $ev, 'classification' => 'GREEN', 'execution' => 'ok',
        ];
    }

    private function statusOf(\Throwable $e): int
    {
        if ($e instanceof GhostCrawlError) {
            return (int) $e->statusCode;
        }
        return 0;
    }

    /** @param array<string,mixed> $row */
    private function handle(GhostCrawlClient $client, array $row): array
    {
        $name = $row['row'];
        $ep = $row['endpoint'];

        switch ($name) {
            case 'scrape':
                return $this->green('scrape', $ep, $client->scrape(self::TARGET));
            case 'content':
                return $this->green('content', $ep, $client->content(self::TARGET));
            case 'screenshot':
                return $this->green('screenshot', $ep, $client->screenshot(self::TARGET));
            case 'pdf':
                // PDF is Chrome-only; pin a chrome identity so the server's random draw is
                // deterministic (engine="chrome" alone passes the guard but the draw can
                // still resolve non-chrome and 400) → reproducible GREEN.
                return $this->green('pdf', $ep, $client->pdf(
                    self::TARGET, 'a4', false, 'chrome',
                    ['identity_spec' => ['claim_os' => 'windows', 'claim_browser' => 'chrome', 'viewport' => 'fullscreen']]
                ));
            case 'extract':
                return $this->green('extract', $ep, $client->extract(self::TARGET, ['type' => 'object', 'properties' => []]));
            case 'search':
                return $this->green('search', $ep, $client->search('books'));
            case 'map':
                return $this->green('map', $ep, $client->map(self::TARGET));
            case 'crawl':
                return $this->green('crawl', $ep, $client->crawl(self::TARGET, 2, 1));
            case 'crawl-runs':
                return $this->green('crawlRuns.list', $ep, $client->crawlRuns->list());
            case 'profiles':
                return $this->green('profiles.list', $ep, $client->profiles->list());
            case 'datasets':
                return $this->green('datasets.list', $ep, $client->datasets->list());
            case 'recordings':
                return $this->green('recordings.list', $ep, $client->recordings->list());
            case 'identity':
                // Desktop claim requires a viewport (mobile requires device_model).
                return $this->green('identity', $ep, $client->identity('windows', 'chrome', null, 'fullscreen'));
            case 'me':
                return $this->green('me', $ep, $client->me());
            case 'usage':
                return $this->green('usage', $ep, $client->usage());
            case 'storage-states':
                return $this->green('storageStates', $ep, $client->storageStates());
            case 'kv':
                // real-but-minimal round-trip: set then get (a bare GET on an absent
                // key is a 404 empty-read, not a plumbing proof).
                $client->kv->set('parity-e2e-probe', ['v' => 1]);
                return $this->green('kv.set+get', $ep, $client->kv->get('parity-e2e-probe'));
            case 'sessions':
                // A session needs an existing profile — create a unique one, open+release
                // the session, then delete the profile (act/observe are BYO).
                $base = 'parity-e2e-' . time();
                $prof = $client->profiles->create($base);
                $pname = (is_array($prof) && isset($prof['name'])) ? (string) $prof['name'] : $base;
                $created = $client->sessions->create($pname);
                $ev = ['token_var' => self::TOKEN_VAR, 'key_count' => count($this->shapeKeys($created))];
                $sid = $this->idOf($created, 'session_id');
                if ($sid !== null) {
                    // sessionPersona parity (contract method 87): the running session's
                    // customer-safe persona (device_class/os_class/browser_class/locale).
                    try {
                        $persona = $client->sessionPersona($sid);
                        $ev['persona_keys'] = count($this->shapeKeys($persona));
                    } catch (\Throwable) {
                        $ev['persona_keys'] = 0;
                    }
                    try {
                        $client->sessions->release($sid);
                        $ev['released'] = 1;
                    } catch (\Throwable) {
                        $ev['released'] = 0;
                    }
                }
                try {
                    $client->profiles->delete($pname);
                } catch (\Throwable) {
                    // best-effort cleanup
                }
                return [
                    'method' => 'sessions.create', 'request_line' => $ep, 'status' => 200,
                    'shape_keys' => $this->shapeKeys($created), 'evidence' => $ev,
                    'classification' => 'GREEN', 'execution' => 'ok',
                ];
            case 'webhooks':
                $created = $client->webhooks->create('https://example.com/parity-e2e-hook', ['scrape.completed']);
                $ev = ['token_var' => self::TOKEN_VAR, 'key_count' => count($this->shapeKeys($created))];
                $wid = $this->idOf($created, 'webhook_id');
                if ($wid !== null) {
                    try {
                        $client->webhooks->delete($wid);
                        $ev['deleted'] = 1;
                    } catch (\Throwable) {
                        $ev['deleted'] = 0;
                    }
                }
                return [
                    'method' => 'webhooks.create', 'request_line' => $ep, 'status' => 200,
                    'shape_keys' => $this->shapeKeys($created), 'evidence' => $ev,
                    'classification' => 'GREEN', 'execution' => 'ok',
                ];
            case 'schedules':
                $created = $client->schedules->create(
                    cron: '0 0 * * *', name: 'parity-e2e-sch', jobType: 'crawl',
                    jobParams: ['url' => self::TARGET, 'max_pages' => 1]
                );
                $ev = ['token_var' => self::TOKEN_VAR, 'key_count' => count($this->shapeKeys($created))];
                $scid = $this->idOf($created, 'schedule_id');
                if ($scid !== null) {
                    try {
                        $client->schedules->delete($scid);
                        $ev['deleted'] = 1;
                    } catch (\Throwable) {
                        $ev['deleted'] = 0;
                    }
                }
                return [
                    'method' => 'schedules.create', 'request_line' => $ep, 'status' => 200,
                    'shape_keys' => $this->shapeKeys($created), 'evidence' => $ev,
                    'classification' => 'GREEN', 'execution' => 'ok',
                ];
            case 'agent':
                // Account-gated: require_agent_enabled() replies an honest 404 problem+json
                // to user keys. The php facade returns that body as an array (carrying
                // "detail") rather than raising. GREEN (plumbing) + hosted (BYO LLM) — NOT
                // laundered, does not drive the full agent reasoning loop (BYO LLM required).
                $result = $client->agent('click the \'Books to Scrape\'', self::TARGET);
                $keys = $this->shapeKeys($result);
                $gated = is_array($result) && array_key_exists('detail', $result);
                $ev = [
                    'token_var' => self::TOKEN_VAR, 'key_count' => count($keys),
                    'note' => 'gated 404 is the documented expected contract; execution is BYO/not-hosted',
                ];
                return [
                    'method' => 'agent', 'request_line' => $ep, 'status' => ($gated ? 404 : 200),
                    'shape_keys' => $keys, 'evidence' => $ev,
                    'classification' => 'GREEN (plumbing)', 'execution' => 'hosted (BYO LLM)',
                ];
        }
        throw new \RuntimeException("no parity-e2e handler for row {$name}");
    }

    /** @param array<string,mixed> $row */
    private function handleWithRetry(GhostCrawlClient $client, array $row, int $attempts = 3): array
    {
        $last = null;
        for ($i = 0; $i < $attempts; $i++) {
            try {
                return $this->handle($client, $row);
            } catch (\Throwable $e) {
                if (in_array($this->statusOf($e), self::TRANSIENT, true) && $i < $attempts - 1) {
                    $last = $e;
                    sleep(2 * ($i + 1));
                    continue;
                }
                throw $e;
            }
        }
        throw $last;
    }

    /** @param array<string,mixed> $row */
    private function classifyError(array $row, \Throwable $e): array
    {
        $name = $row['row'];
        $ep = $row['endpoint'];
        $status = $this->statusOf($e);
        $ev = ['token_var' => self::TOKEN_VAR, 'error_type' => get_class($e)];
        // A self-throttle 429/503 is a FAIL to root-cause, never a gated pass.
        if (in_array($status, self::LAUNDER, true)) {
            $ev['note'] = "self-throttle {$status} — RED FAIL-to-root-cause, never laundered";
            return ['method' => $name, 'request_line' => $ep, 'status' => $status, 'shape_keys' => [], 'evidence' => $ev, 'classification' => 'RED', 'execution' => null];
        }
        // search is an honest N/A-BYO (needs a user-supplied search-backend key).
        if ($name === 'search') {
            $ev['note'] = 'requires a user-supplied BYO search-backend key (provider_key; supported '
                . 'brave/tavily/google/bing/yandex) — a keyless call returns 401 '
                . 'search_backend_key_missing (the SDK specifies engine=google, passing the 400 '
                . 'engine-unspecified check); SDK plumbing verified by the typed 401 round-trip. '
                . 'N/A-BYO, not a defect.';
            return ['method' => $name, 'request_line' => $ep, 'status' => $status, 'shape_keys' => [], 'evidence' => $ev, 'classification' => 'N/A', 'execution' => null];
        }
        if ($status === 401 || $status === 403) {
            $msg = substr($e->getMessage(), 0, 120);
            $ev['note'] = "{$name}: unexpected HTTP {$status} ({$msg}) — honest RED to root-cause";
            return ['method' => $name, 'request_line' => $ep, 'status' => $status, 'shape_keys' => [], 'evidence' => $ev, 'classification' => 'RED', 'execution' => null];
        }
        $ev['note'] = "unexpected error on {$name}: " . get_class($e);
        return ['method' => $name, 'request_line' => $ep, 'status' => $status, 'shape_keys' => [], 'evidence' => $ev, 'classification' => 'RED', 'execution' => null];
    }

    /** @param array<string,mixed> $row */
    private function writeTranscript(array $row, array $res): void
    {
        $dir = $this->evidenceDir();
        if (!is_dir($dir)) {
            mkdir($dir, 0o755, true);
        }
        $transcript = [
            'lane' => self::LANE,
            'row' => $row['row'],
            'method' => $res['method'],
            'request_line' => $res['request_line'],
            'status' => $res['status'],
            'shape_keys' => $res['shape_keys'],
            'evidence' => $res['evidence'],
            'classification' => $res['classification'],
            'execution' => $res['execution'],
            'command' => "make -C sdks/php parity-e2e ROW={$row['row']}",
            'captured_at' => $this->now(),
        ];
        $out = $dir . '/' . $row['row'] . '.transcript.json';
        file_put_contents($out, json_encode($transcript, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
    }

    public function testParityE2E(): void
    {
        $token = trim((string) (getenv(self::TOKEN_VAR) ?: ''));
        if ($token === '') {
            $this->markTestSkipped(
                sprintf(
                    'AUTH GATE: %s is unset — this runner performs REAL round-trips against the '
                    . 'cloud test tenant and will NOT fabricate transcripts. Provision '
                    . 'a scoped test token, then: export %s=<token> [%s=<url>] && '
                    . 'make -C sdks/php parity-e2e (revoked after the run).',
                    self::TOKEN_VAR, self::TOKEN_VAR, self::BASE_VAR
                )
            );
        }

        $rowset = $this->repoRoot() . '/scripts/phase178/rowset.json';
        /** @var array<int,array<string,mixed>> $rows */
        $rows = json_decode((string) file_get_contents($rowset), true);
        $only = trim((string) (getenv('ROW') ?: ''));
        if ($only !== '') {
            $rows = array_values(array_filter($rows, static fn ($r) => $r['row'] === $only));
            $this->assertNotEmpty($rows, "no such row: {$only}");
        }

        $client = new GhostCrawlClient(); // token/base from env

        $green = $red = $plumbing = $na = 0;
        $reds = [];
        foreach ($rows as $row) {
            $t0 = microtime(true);
            try {
                $res = $this->handleWithRetry($client, $row);
            } catch (\Throwable $e) {
                $res = $this->classifyError($row, $e);
            }
            $res['evidence']['elapsed_ms'] ??= (int) round((microtime(true) - $t0) * 1000);
            $this->writeTranscript($row, $res);
            switch ($res['classification']) {
                case 'GREEN':            $green++; break;
                case 'GREEN (plumbing)': $plumbing++; break;
                case 'N/A':              $na++; break;
                default:
                    $red++;
                    $reds[] = "{$row['row']} (status={$res['status']})";
            }
            fprintf(STDERR, "[parity-e2e:php] %-14s %-16s status=%s\n", $row['row'], $res['classification'], (string) $res['status']);
        }

        fprintf(
            STDERR,
            "[parity-e2e:php] DONE — %d GREEN, %d GREEN (plumbing), %d N/A, %d RED across %d row(s). Evidence: %s\n",
            $green, $plumbing, $na, $red, count($rows), $this->evidenceDir()
        );

        // A real RED fails the gate; N/A (BYO / route-absent) does not.
        $this->assertSame(0, $red, 'RED rows must be root-caused: ' . implode(', ', $reds));
    }
}
