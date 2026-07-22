<?php

/**
 * quickstart_scrape.php — Scrape a URL and print the content.
 *
 * Usage:
 *   export GHOSTCRAWL_API_KEY=gck_live_YOUR_KEY
 *   php quickstart_scrape.php
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
    $result = $client->scrape('https://example.com', format: 'markdown');

    // The API returns "markdown" when format=markdown, and "status" for the job state.
    $content = $result['markdown'] ?? '';
    $preview = strlen($content) > 200 ? substr($content, 0, 200) . '...' : $content;

    echo 'Status: ' . ($result['status'] ?? 'unknown') . PHP_EOL;
    // identity_id (Phase 140.4-16 response envelope field) — printed so a caller can
    // correlate this exact drive to its server-side egress-exit assignment (D-04, phase 177).
    echo 'identity_id: ' . ($result['identity_id'] ?? 'unknown') . PHP_EOL;
    echo 'Content preview:' . PHP_EOL;
    echo $preview . PHP_EOL;
} catch (GhostCrawlError $e) {
    fwrite(STDERR, "GhostCrawl API error: {$e->getMessage()} (HTTP {$e->statusCode})\n");
    exit(1);
}
