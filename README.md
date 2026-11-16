# ghostcrawl/ghostcrawl — PHP SDK

The official PHP client for the [GhostCrawl](https://ghostcrawl.io) API.
Collect web data at scale — scrape, crawl, search, and extract structured data.

## Install

```bash
composer require ghostcrawl/ghostcrawl
```

Requires PHP 8.1+, `ext-curl`, and `ext-json` (both standard in most PHP distributions).

## Quickstart

`GhostCrawlClient` is the one idiomatic, blocking PHP client — the intended,
first-class shape (there is deliberately no async twin; see [Concurrency](#concurrency)).

```php
<?php
require 'vendor/autoload.php';

use GhostCrawl\GhostCrawlClient;

// Token from constructor or GHOSTCRAWL_API_KEY env var
$client = new GhostCrawlClient('gck_live_YOUR_KEY');

// Scrape a URL — returns a typed result. Read it by property OR by ['key']:
$result = $client->scrape('https://example.com', format: 'markdown');
echo $result->content;              // typed property access
echo $result['content'];            // ['key'] access still works (back-compat)
echo $result->status_code . PHP_EOL;

// Start a crawl run and wait for it to finish — EVENT-DRIVEN: the server blocks
// until the run is terminal (completed/failed/cancelled) or the timeout elapses,
// then returns the run. No client-side poll-with-sleep loop.
$run = $client->crawlRuns->start('https://example.com', maxDepth: 2, maxPages: 50,
                                 wait: true, timeout: 300);
echo "status: " . $run['status'] . PHP_EOL;
// Already have a run_id? Long-poll it the same way (blocks until terminal,
// overall deadline in seconds):
//   $done = $client->crawlRuns->waitForCompletion($run['run_id'], timeout: 600);
// Or omit wait and get notified via a webhook instead.

// Web search — wait: true (default) blocks until results are ready even on a
// cold rotation, then returns a typed result:
$results = $client->search('latest AI research', engine: 'google', limit: 10);
echo count($results->results) . " results\n";   // $results['results'] also works

// Pass wait: false to get the raw job handle back and poll it yourself.
```

## Concurrency

PHP is blocking-native, so each call blocks until it returns. To run many requests
at once, drive them with Guzzle's async promises (a dependency the SDK already
ships) — this is the idiomatic PHP concurrency pattern, not a separate async client:

```php
<?php
use GhostCrawl\GhostCrawlClient;
use GuzzleHttp\Promise\Utils;

$client = new GhostCrawlClient('gck_live_YOUR_KEY');
$urls = ['https://a.example', 'https://b.example', 'https://c.example'];

// Fan out with promises, then settle them together.
$promises = [];
foreach ($urls as $u) {
    $promises[$u] = Utils::task(fn () => $client->scrape($u));
}
foreach (Utils::settle($promises)->wait() as $u => $outcome) {
    if ($outcome['state'] === 'fulfilled') {
        echo $u . ': ' . $outcome['value']->status_code . PHP_EOL;
    }
}

// Or, simplest of all, batch sequentially — clear and rate-limit-friendly:
foreach ($urls as $u) {
    echo $u . ': ' . $client->scrape($u)->status_code . PHP_EOL;
}
```

## Authentication

```php
// Option 1: pass token directly
$client = new GhostCrawlClient('gck_live_YOUR_KEY');

// Option 2: set environment variable (recommended for production)
// export GHOSTCRAWL_API_KEY=gck_live_YOUR_KEY
$client = new GhostCrawlClient();
```

Every request sends `Authorization: Bearer <token>`. This is the only auth scheme the API accepts.

## Extract structured data

```php
<?php
use GhostCrawl\GhostCrawlClient;

$client = new GhostCrawlClient('gck_live_YOUR_KEY');

$data = $client->extract(
    url: 'https://example.com/product',
    schema: [
        'type'       => 'object',
        'properties' => [
            'name'        => ['type' => 'string'],
            'price'       => ['type' => 'number'],
            'description' => ['type' => 'string'],
        ],
    ]
);
echo $data['name'] . ' — $' . $data['price'] . PHP_EOL;
```

## Browser utilities — content, screenshot, PDF

```php
<?php
use GhostCrawl\GhostCrawlClient;

$client = new GhostCrawlClient('gck_live_YOUR_KEY');

// Rendered content as a JSON envelope: [url, status, format, status_code, content, bytes]
$page = $client->content('https://example.com');
echo $page['status_code'] . ' — ' . $page['bytes'] . ' bytes' . PHP_EOL;

// Screenshot — returns raw PNG bytes
$png = $client->screenshot('https://example.com', fullPage: true);
file_put_contents('page.png', $png);

// PDF — returns raw application/pdf bytes (Chrome-only; a Firefox/WebKit identity
// is rejected with a 400 pdf_engine_unsupported)
$pdf = $client->pdf('https://example.com', paperFormat: 'a4');
file_put_contents('page.pdf', $pdf);
```

## Agent (BYO model, account-gated)

The agent lane runs a natural-language browser task. It is **bring-your-own-model** (supply your
own `provider_config` in the request body) and **account-gated**: the API returns `404 not_found`
unless the capability is enabled for your account. `agent()` does **not** throw on that 404 — it
returns the `problem+json` body as an array, so branch on `isset($result['detail'])`.

```php
<?php
use GhostCrawl\GhostCrawlClient;

$client = new GhostCrawlClient('gck_live_YOUR_KEY');

// provider_config is BYO — reference your provider key by env-var name, never a literal.
$result = $client->agent(
    task: [
        'instruction' => "click the 'Books to Scrape' link",
        'start_url'   => 'https://books.toscrape.com',
    ],
    extra: [
        'provider_config' => [
            'provider' => 'openai',
            'api_key'  => 'OPENAI_API_KEY',
            'model'    => 'gpt-4o',
        ],
    ]
);
if (isset($result['detail'])) {
    echo "agent lane not enabled for this account (BYO/gated)" . PHP_EOL;
} else {
    print_r($result);
}
```

## Error handling

```php
<?php
use GhostCrawl\GhostCrawlClient;
use GhostCrawl\AuthenticationError;
use GhostCrawl\PaymentRequiredError;
use GhostCrawl\RateLimitError;
use GhostCrawl\APIError;
use GhostCrawl\GhostCrawlError;

$client = new GhostCrawlClient('gck_live_YOUR_KEY');

try {
    $result = $client->scrape('https://example.com');
} catch (AuthenticationError $e) {
    echo "Invalid API key — check your token\n";
} catch (PaymentRequiredError $e) {
    echo "Usage limit reached — upgrade your plan\n";
} catch (RateLimitError $e) {
    echo "Rate limit reached — retry after a short delay\n";
} catch (APIError $e) {
    echo "Server error: {$e->statusCode}\n";
} catch (GhostCrawlError $e) {
    echo "API error: {$e->getMessage()} (HTTP {$e->statusCode})\n";
}
```

## Self-hosted

```php
$client = new GhostCrawlClient('gck_live_YOUR_KEY', 'http://localhost:8080');
```

## All resources

| Resource | Method / property | Key operations |
|----------|------------------|----------------|
| Scraping | `$client->scrape($url)` | Render and return page content |
| Web search | `$client->search($query)` | Search Google, Bing, DuckDuckGo |
| Data extraction | `$client->extract($url, $schema)` | Structured JSON from any page |
| Deep crawl | `$client->crawl($url)` | Crawl a site depth-first |
| URL map | `$client->map($url)` | Discover all reachable URLs |
| Content | `$client->content($url)` | Rendered content JSON envelope |
| Screenshot | `$client->screenshot($url)` | Capture a URL to PNG bytes |
| PDF | `$client->pdf($url)` | Render a URL to PDF bytes (Chrome-only) |
| Agent (BYO) | `$client->agent(task: […])` | NL browser task — account-gated, BYO model |
| Account | `$client->me()` | Get account info and usage |
| Crawl runs | `$client->crawlRuns` | start (`wait:`/`timeout:`), waitForCompletion, list, get, cancel |
| Sessions | `$client->sessions` | create, list, extend, release |
| Profiles | `$client->profiles` | list, get, create, update, delete |
| Webhooks | `$client->webhooks` | list, get, create, delete, rotateSecret |
| Schedules | `$client->schedules` | list, get, create, delete |
| Datasets | `$client->datasets` | list, get, create, delete, rows, append |
| Recordings | `$client->recordings` | list, get, delete |
| Key-Value Store | `$client->kv` | get, set, delete |

## Account & session persona

`me()` returns your account profile — including `max_concurrency`, the number of
sessions your plan may run at once. `usage()` reports the current billing window.
`sessionPersona($sessionId)` returns a running session's customer-safe persona: a
display-only whitelist of `device_class`, `os_class`, `browser_class`, and `locale`
(never any raw or internal detail).

```php
$me = $client->me();
echo $me['max_concurrency'];                 // concurrent-session ceiling for your plan

$persona = $client->sessionPersona($sessionId);
echo "{$persona['device_class']} {$persona['os_class']} " .
     "{$persona['browser_class']} {$persona['locale']}";
```

## License

MIT — see [LICENSE](LICENSE).
