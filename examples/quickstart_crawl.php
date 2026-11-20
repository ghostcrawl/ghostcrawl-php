<?php

/**
 * quickstart_crawl.php — Start a crawl run and BLOCK until it completes.
 *
 * Completion is event-driven: the SDK long-polls
 * GET /v1/crawl-runs/{run_id}?wait=true&timeout_s=N, which the server holds open
 * until the run is terminal (completed | failed | cancelled). There is NO
 * client-side sleep-poll loop — the only waiting is the server-side block.
 *
 * Usage:
 *   export GHOSTCRAWL_API_KEY=gck_live_YOUR_KEY
 *   php quickstart_crawl.php
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GhostCrawl\GhostCrawlClient;
use GhostCrawl\GhostCrawlError;

$apiKey = getenv('GHOSTCRAWL_API_KEY') ?: null;
if (empty($apiKey)) {
    fwrite(STDERR, "Error: GHOSTCRAWL_API_KEY environment variable is not set.\n");
    fwrite(STDERR, "Get your key at https://ghostcrawl.io and set it with:\n");
    fwrite(STDERR, "  export GHOSTCRAWL_API_KEY=gck_live_YOUR_KEY\n");
    exit(1);
}

try {
    $client = new GhostCrawlClient($apiKey);

    // Start a crawl run.
    $run = $client->crawlRuns->start(
        url: 'https://example.com',
        maxDepth: 2,
        maxPages: 50
    );

    $runId = $run['run_id'] ?? 'unknown';
    echo 'Crawl run started' . PHP_EOL;
    echo '  run_id: ' . $runId . PHP_EOL;
    echo '  status: ' . ($run['status'] ?? 'unknown') . PHP_EOL;

    // Block until the run finishes — event-driven server-side long-poll, up to
    // 10 minutes total. Retry only on legitimately-transient (retryable) errors;
    // each waitForCompletion resumes waiting from where the last window left off.
    $deadline = microtime(true) + 600;
    while (true) {
        try {
            $run = $client->crawlRuns->waitForCompletion($runId, timeout: 600);
            break;
        } catch (GhostCrawlError $e) {
            if (!$e->retryable || microtime(true) >= $deadline) {
                throw $e;
            }
            fwrite(STDERR, "Transient error ({$e->code}); resuming wait...\n");
        }
    }

    echo 'Final status: ' . ($run['status'] ?? 'unknown') . PHP_EOL;
    if (($run['status'] ?? null) === 'completed') {
        $pages = $run['results'] ?? $run['pages'] ?? [];
        echo '  pages crawled: ' . (is_countable($pages) ? count($pages) : 0) . PHP_EOL;
    }
} catch (GhostCrawlError $e) {
    fwrite(STDERR, "GhostCrawl API error: {$e->getMessage()} (HTTP {$e->statusCode})\n");
    exit(1);
}
