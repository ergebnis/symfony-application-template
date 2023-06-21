APP_ENV:=test
CONNECTION_NAME_DEFAULT:=default
ENTITY_MANAGER_NAME_DEFAULT:=default

.PHONY: it
it: refactoring coding-standards security-analysis static-code-analysis tests ## Runs the refactoring, coding-standards, security-analysis, static-code-analysis, and tests targets

.PHONY: cache
cache: vendor ## Warms up the cache
	composer dump-env ${APP_ENV}
	bin/console cache:warmup --env=${APP_ENV}

.PHONY: code-coverage
code-coverage: vendor ## Collects coverage from running unit tests with phpunit/phpunit
	mkdir -p .build/phpunit
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml --coverage-text

.PHONY: coding-standards
coding-standards: vendor ## Lints YAML files with yamllint, normalizes composer.json with ergebnis/composer-normalize, converts YAML configuration to PHP format, and fixes code style issues with friendsofphp/php-cs-fixer
	yamllint -c .yamllint.yaml --strict .
	composer normalize
	vendor/bin/config-transformer config/
	mkdir -p .build/php-cs-fixer/
	PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --diff --verbose

.PHONY: dependency-analysis
dependency-analysis: phive vendor ## Runs a dependency analysis with maglnet/composer-require-checker
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
	mkdir -p .build/infection/
	vendor/bin/infection --configuration=infection.json

.PHONY: phive
phive: .phive## Installs dependencies with phive
	mkdir -p .build/phive/
	PHIVE_HOME=.build/phive phive install --trust-gpg-keys 0x033E5F8D801A2F8D

.PHONY: refactoring
refactoring: vendor ## Runs automated refactoring with rector/rector
	vendor/bin/rector process --config=rector.php

.PHONY: security-analysis
security-analysis: vendor ## Runs a security analysis with composer
	composer audit

.PHONY: static-code-analysis
static-code-analysis: vendor ## Runs a static code analysis with vimeo/psalm
	mkdir -p .build/psalm/
	vendor/bin/psalm --config=psalm.xml --clear-cache
	vendor/bin/psalm --config=psalm.xml --show-info=false --stats --threads=4

.PHONY: static-code-analysis-baseline
static-code-analysis-baseline: vendor ## Generates a baseline for static code analysis vimeo/psalm
	mkdir -p .build/psalm/
	vendor/bin/psalm --config=psalm.xml --clear-cache
	vendor/bin/psalm --config=psalm.xml --set-baseline=psalm-baseline.xml

.PHONY: tests
tests: vendor ## Runs unit, integration, and functional tests with phpunit/phpunit
	mkdir -p .build/phpunit/
	vendor/bin/phpunit --configuration=test/Unit/phpunit.xml
	vendor/bin/phpunit --configuration=test/Integration/phpunit.xml
	vendor/bin/phpunit --configuration=test/Functional/phpunit.xml

.PHONY: symfony
symfony: vendor ## Synchronizes symfony recipes
	composer symfony:sync-recipes

vendor: composer.json composer.lock
	composer validate --strict
	composer install --no-interaction --no-progress
