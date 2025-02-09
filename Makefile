FILE=compose.yaml
OVERRIDE=compose.override.yaml
DOCKER_COMPOSE = docker-compose -f $(FILE) -f $(OVERRIDE)

EXEC_API = $(DOCKER_COMPOSE) exec dataviz-api
EXEC_BO = $(DOCKER_COMPOSE) exec dataviz-bo-api
SYMFONY = $(EXEC_API) bin/console
SYMFONY_BO = $(EXEC_BO) bin/console

ARG ?=

## ----------------
## 🛠 Project Commands
## ----------------
build: ## 🔧 Build Docker images
	@$(DOCKER_COMPOSE) pull --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull --no-cache

kill: ## 💀 Stop and remove all containers, then clean up the system
	docker compose down -v
	docker system prune -a --volumes
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

up: ## 🚀 Start containers and open related URLs
	$(DOCKER_COMPOSE) up -d
	wslview https://localhost:4430
	wslview https://localhost:443
	wslview http://localhost:4040

start: ## ▶️  Start containers without recreating them
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## ⏹ Stop running containers
	$(DOCKER_COMPOSE) stop

ps: ## 📌 Show currently running containers
	$(DOCKER_COMPOSE) ps

install: ## 🏗 Initialize the project (build + start)
install: build start

reset: ## ♻️ Fully reset the project (kill + install)
reset: kill install

chown: ## 🛠 Fix user access permissions
	sudo chown -R $$USER:$$USER .

## ----------------
## 🏛 Database Commands
## ----------------
db-create-full: ## 🗄 Create all databases (dev + test)
	$(SYMFONY_BO) doctrine:database:create --if-not-exists
	$(SYMFONY_BO) doctrine:database:create --if-not-exists --connection=pool 

db-make-migration: ## 📜 Generate a new migration
	$(SYMFONY_BO) doctrine:migrations:diff

db-migrate: ## 🔄 Execute all migrations
	$(SYMFONY_BO) doctrine:migrations:migrate -n
	$(SYMFONY_BO) doctrine:migrations:migrate -n --em=pool --configuration=migrations/Datapool/doctrine_migrations.yaml

db-fixtures: ## 🧪 Load database fixtures
	$(SYMFONY_BO) doctrine:fixtures:load -n

db-full: ## 🏗 Create DB, run migrations, and load fixtures
db-full: db-create-full db-migrate db-fixtures

## ----------------
## ✅ Tests
## ----------------
define run_phpunit
	$(1) vendor/bin/phpunit $(ARG)
endef

test-u-api: ## 🧪 Run unit tests for API
	$(call run_phpunit,$(EXEC_API) --testsuite unit)

test-i-api: ## 🛠 Run integration tests for API
	$(call run_phpunit,$(EXEC_API) --testsuite api)

test-api: ## 🚀 Run all API tests
	$(call run_phpunit,$(EXEC_API))

test-c-api: ## 📊 Test coverage - you may need to "apt install wslu" package
	$(EXEC_API) vendor/bin/phpunit --coverage-html tests/coverage
	wslview ./dataviz-bo-api/tests/coverage/index.html

test-i-bo: ## 🛠 Run integration tests for BO
	$(call run_phpunit,$(EXEC_BO) --testsuite api)

test-bo: ## 🚀 Run all BO tests
	$(call run_phpunit,$(EXEC_BO))

test-c-bo: ## 📊 Test coverage - you may need to "apt install wslu" package
	$(EXEC_BO) vendor/bin/phpunit --coverage-html tests/coverage
	wslview ./dataviz-bo-api/tests/coverage/index.html

test: ## 🚀 Run all tests
	$(call run_phpunit,$(EXEC_API))
	$(call run_phpunit,$(EXEC_BO))

## ----------------
## 🔍 Code Quality
## ----------------
install-xdebug: ## 🐞 Install Xdebug extension
	$(EXEC_API) pecl install xdebug
	$(EXEC_API) docker-php-ext-enable xdebug

apply-php-cs-fixer: ## 🎨 Fix PHP code style
	$(EXEC_API) vendor/bin/php-cs-fixer fix --using-cache=no --verbose --diff
	$(EXEC_API) vendor/bin/php-cs-fixer fix ./tests --using-cache=no --verbose --diff

phpstan: ## 🔍 Run static analysis on PHP code
	$(EXEC_API) vendor/bin/phpstan analyse src

apply-bo-csfixer: ## 🎨 Fix PHP code style
	$(EXEC_BO) vendor/bin/php-cs-fixer fix --using-cache=no --verbose --diff
	$(EXEC_BO) vendor/bin/php-cs-fixer fix ./tests --using-cache=no --verbose --diff

phpstan-bo: ## 🔍 Run static analysis on PHP code
	$(EXEC_BO) vendor/bin/phpstan analyse src

## ----------------
## 📜 Help
## ----------------
.PHONY: build start stop vendor test php-cs-fixer apply-php-cs-fixer help

.DEFAULT_GOAL := help
help:
	@echo "\n\033[1;36mAvailable commands:\033[0m"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
