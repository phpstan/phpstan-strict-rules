.PHONY: check
check: lint cs tests phpstan

.PHONY: tests
tests: vendor
	php vendor/bin/phpunit

.PHONY: lint
lint: vendor
	php vendor/bin/parallel-lint --colors \
		src tests

.PHONY: cs-install
cs-install:
	git clone https://github.com/phpstan/build-cs.git || true
	git -C build-cs fetch origin && git -C build-cs reset --hard origin/main
	composer install --working-dir build-cs

.PHONY: cs
cs: cs-install
	php build-cs/vendor/bin/phpcs --standard=build-cs/phpcs.xml src tests

.PHONY: cs-fix
cs-fix: cs-install
	php build-cs/vendor/bin/phpcbf --standard=build-cs/phpcs.xml src tests

.PHONY: phpstan
phpstan: vendor
	php vendor/bin/phpstan analyse -l 8 -c phpstan.neon src tests

vendor: composer.json composer.lock
	composer --no-interaction install

composer.lock:
	test -f composer.lock || composer --no-interaction update
