APP_ENV:=test
CONNECTION_NAME_DEFAULT:=default
ENTITY_MANAGER_NAME_DEFAULT:=default

.PHONY: it
it: coding-standards static-code-analysis tests ## Runs the coding-standards, static-code-analysis, and tests targets

.PHONY: cache
cache: vendor ## Warms up the cache
	composer dump-env ${APP_ENV}
	bin/console cache:warmup --env=${APP_ENV}

.PHONY: code-coverage
code-coverage: vendor ## Collects coverage from running unit tests with phpunit/phpunit
	mkdir -p .build/phpunit
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml --coverage-text

.PHONY: coding-standards
coding-standards: vendor ## Normalizes composer.json with ergebnis/composer-normalize, lints YAML files with yamllint, converts YAML configuration to PHP format, and fixes code style issues with friendsofphp/php-cs-fixer
	composer normalize
	yamllint -c .yamllint.yaml --strict .
	vendor/bin/config-transformer switch-format config
	mkdir -p .build/php-cs-fixer
	vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --diff --verbose

.PHONY: dependency-analysis
dependency-analysis: vendor ## Runs a dependency analysis with maglnet/composer-require-checker
	.phive/composer-require-checker check --config-file=$(shell pwd)/composer-require-checker.json

.PHONY: doctrine
doctrine: vendor environment ## Runs doctrine commands to set up a local test database
	bin/console doctrine:database:drop --connection=${CONNECTION_NAME_DEFAULT} --env=${APP_ENV} --force --if-exists
	bin/console doctrine:database:create --connection=${CONNECTION_NAME_DEFAULT} --env=${APP_ENV}
	bin/console doctrine:migrations:status --env=${APP_ENV}
	bin/console doctrine:migrations:migrate --env=${APP_ENV} --allow-no-migration --no-interaction
	bin/console doctrine:schema:validate --em=${ENTITY_MANAGER_NAME_DEFAULT} || (bin/console doctrine:migrations:diff --env=${APP_ENV} && false)

.PHONY: environment
environment: vendor ## Dumps environment variables
	composer dump-env ${APP_ENV}

.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: mutation-tests
mutation-tests: vendor ## Runs mutation tests with infection/infection
	mkdir -p .build/infection
	vendor/bin/infection --configuration=infection.json

.PHONY: static-code-analysis
static-code-analysis: vendor cache ## Runs a static code analysis with vimeo/psalm
	mkdir -p .build/psalm
	vendor/bin/psalm --config=psalm.xml --diff --show-info=false --stats --threads=4

.PHONY: static-code-analysis-baseline
static-code-analysis-baseline: vendor cache ## Generates a baseline for static code analysis with vimeo/psalm
	mkdir -p .build/psalm
	vendor/bin/psalm --config=psalm.xml --clear-cache
	vendor/bin/psalm --config=psalm.xml --set-baseline=psalm-baseline.xml

.PHONY: tests
tests: vendor ## Runs auto-review, unit, and integration tests with phpunit/phpunit
	mkdir -p .build/phpunit
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml
	vendor/bin/phpunit --configuration=test/Integration/phpunit.xml
	vendor/bin/phpunit --configuration=test/Functional/phpunit.xml

.PHONY: symfony
symfony: vendor ## Synchronizes symfony recipes
	composer symfony:sync-recipes

vendor: composer.json composer.lock
	composer validate --strict
	composer install --no-interaction --no-progress
