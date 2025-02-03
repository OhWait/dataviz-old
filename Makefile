FILE=compose.yaml
OVERRIDE=compose.override.yaml
EXEC = $(DOCKER_COMPOSE) exec -it dataviz-api
EXEC_PHP = $(DOCKER_COMPOSE) exec dataviz-api
SYMFONY = $(EXEC_PHP) bin/console
MAKEFILE_LIST = Makefile
ARG ?=

DOCKER_COMPOSE = docker-compose -f $(FILE) -f $(OVERRIDE)

##
## Project
## -------
##
build:
	@$(DOCKER_COMPOSE) pull --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull --no-cache

kill: ## KILL THEM ALL !!
	docker compose down -v
	docker system prune -a --volumes
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

up: ## chill reup
	$(DOCKER_COMPOSE) up -d
	wslview https://localhost:4430
	wslview https://localhost:443
	wslview http://localhost:8000

start: ## Start project containers
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop project containers
	$(DOCKER_COMPOSE) stop

ps: ## Check current containers
	$(DOCKER_COMPOSE) ps

install: ## Initialisation project - you may want db-create + db-migrate + db-fixtures later
install: build start

reset: ## Stop and start a fresh install of the project
reset: kill install

chown: ## Fix user access denied
	sudo chown -R $$USER:$$USER .

##
## PHP
## -------
##
logs: ## Logs app container
	$(DOCKER_COMPOSE) logs -f -t --tail 250 php

bash: ## Attach shell
	$(EXEC) /bin/sh

vendor-require:
	$(EXEC_PHP) composer require

vendor-install:
	$(EXEC_PHP) composer install

vendor-update:
	$(EXEC_PHP) composer update

.PHONY= build start stop vendor

##
## App cmd
## -------
##
entity: ## UPDATE an entity (create doesnt work)
	$(SYMFONY) app:entity

migration: ## Generate new migration file
	$(SYMFONY) make:migration

pool-migration: ## Generate new migration file
	$(SYMFONY) make:migration --configuration=migrations/Datapool/doctrine_migrations.yaml

## 
## Database
## -------
##
db-create-full: ## Create ALL DB (dev + test)
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:database:create --if-not-exists --connection=pool 
#	$(SYMFONY) doctrine:database:create --if-not-exists -e test
#	$(SYMFONY) doctrine:database:create --if-not-exists -e test --connection=pool

db-migrate: ## Execute ALL migrations (dev + test)
	$(SYMFONY) doctrine:migrations:migrate -n
	$(SYMFONY) doctrine:migrations:migrate -n --em=pool --configuration=migrations/Datapool/doctrine_migrations.yaml
#	$(SYMFONY) doctrine:migrations:migrate -n -e test
#	$(SYMFONY) doctrine:migrations:migrate -n -e test --em=pool --configuration=migrations/Datapool/doctrine_migrations.yaml

db-fixtures: ## Play fixtures
	$(SYMFONY) doctrine:fixtures:load -n
#	$(SYMFONY) doctrine:fixtures:load -n --env=test

db-full: ## create migrate and implements fixtures
db-full: db-create-full db-migrate db-fixtures


##
## Tests
## -------
##
test-unit: ## Unit tests
	$(EXEC_PHP) vendor/bin/phpunit --testsuite unit $(ARG)

test-unit-coverage: ## Test coverage
	$(EXEC_PHP) vendor/bin/phpunit --testsuite unit --coverage-html tests/coverage-unit
	wslview ./api/tests/coverage-unit/index.html

test-api: ## Fonctionnal tests - you can pass arguments with `ARG="--filter TestClassName"
	$(EXEC_PHP) vendor/bin/phpunit --testsuite api $(ARG)

test: ## Launch all tests
	$(EXEC_PHP) vendor/bin/phpunit $(ARG)

test-coverage: ## Test coverage
	$(EXEC_PHP) vendor/bin/phpunit --coverage-html tests/coverage
	wslview ./api/tests/coverage/index.html

.PHONY= test

##
## Quality assurance
## -------
##
install-xdebug: ## install xdebug
	$(EXEC_PHP) pecl install xdebug
	$(EXEC_PHP) docker-php-ext-enable xdebug

apply-php-cs-fixer: ## clean php syntax
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --using-cache=no --verbose --diff
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix ./tests --using-cache=no --verbose --diff

phpstan: ## check typage logic
	$(EXEC_PHP) vendor/bin/phpstan analyse src

.PHONY= php-cs-fixer apply-php-cs-fixer

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/' 
.PHONY: help