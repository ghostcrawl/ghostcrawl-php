# php lane one-command parity runner.
#
# `make parity-e2e` runs tests/ParityE2ETest.php (phpunit), which exercises EVERY
# user-surface row in scripts/phase178/rowset.json ONCE against the REAL cloud
# test tenant and writes one transcript per row to 178-EVIDENCE/php/ (per
# scripts/phase178/TRANSCRIPT-SCHEMA.md).
#
# Secrets: the token is read from GHOSTCRAWL_API_KEY (NEVER hardcoded); if
# it is unset the test SKIPS and fabricates nothing. The real-backend sweep is
# wrapped in the shared flock run-lock (scripts/phase178/parity-run.sh) so
# concurrent-wave lanes serialize their hits to the single shared tenant (W2).
# NOTE: this is a live-network integration run and is EXPECTED to exceed the 30s
# soft-latency guidance — network-bound, not a hang (W5).
#
#   export GHOSTCRAWL_API_KEY='<locked-down test-tenant token>'   # revoked after run
#   export GHOSTCRAWL_BASE_URL='<cloud test tenant base URL>'     # optional
#   make -C sdks/php parity-e2e            # all rows
#   make -C sdks/php parity-e2e ROW=pdf    # one row
SHELL := /bin/bash
REPO_ROOT := $(shell cd ../.. && pwd)

.PHONY: parity-e2e install lint

# composer install (was seeded in Plan 01); idempotent — brings up vendor/ + phpunit.
install:
	composer install --no-interaction --prefer-dist

lint:
	php -l src/GhostCrawlClient.php

# vendor/ must exist before phpunit can autoload; install if it is missing, then
# run the single parity file with the composer autoloader as the bootstrap (no
# phpunit.xml needed). ROW is threaded to the runner env; the test writes evidence.
parity-e2e:
	@[ -x vendor/bin/phpunit ] || composer install --no-interaction --prefer-dist
	@ROW="$(ROW)" $(REPO_ROOT)/scripts/phase178/parity-run.sh php -- \
		php -d default_socket_timeout=300 vendor/bin/phpunit --bootstrap vendor/autoload.php --no-configuration --colors=never tests/ParityE2ETest.php
