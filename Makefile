FILE=compose.yaml
OVERRIDE=compose.override.yaml
DOCKER_COMPOSE = docker-compose -f $(FILE) -f $(OVERRIDE)

EXEC_API = docker exec dataviz-api
EXEC_BO = docker exec dataviz-bo-api
EXEC_FRONT = docker exec -it dataviz-front
EXEC_D_FRONT = docker exec -d dataviz-front
SYMFONY_BO = $(EXEC_BO) bin/console
SYMFONY_API = $(EXEC_API) bin/console

ARG ?=

## ----------------
## 🛠 Project Commands
## ----------------
build: ## 🔧 Build Docker images
	@$(DOCKER_COMPOSE) pull --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build --pull --no-cache

kill: ## 💀 Stop and remove all containers, then clean up the system
	$(DOCKER_COMPOSE) down -v --remove-orphans
	docker system prune -a --volumes

up: ## 🚀 Start containers and open related URLs
	$(DOCKER_COMPOSE) up -d
	$(EXEC_D_FRONT) yarn dev
	wslview https://localhost:4430
	wslview https://localhost:443
	wslview http://localhost:4040
	wslview http://localhost:7800

start: ## ▶️  Start containers without recreating them
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## ⏹ Stop running containers
	$(DOCKER_COMPOSE) stop

ps: ## 📌 Show currently running containers
	$(DOCKER_COMPOSE) ps

install: build up ## 🏗 Initialize the project (build + start)

reset: kill install ## ♻️ Fully reset the project (kill + install)

chown: ## 🛠 Fix user access permissions
	sudo chown -R $$USER:$$USER .

assets-missing: ## 🛠 Fix swagger missing
	$(SYMFONY_API) assets:install --symlink --relative
	$(SYMFONY_BO) assets:install --symlink --relative

## ----------------
## 🏛 Database Commands
## ----------------
db-create: ## 🗄 Create databases (dev + test)
	$(SYMFONY_BO) doctrine:database:create --if-not-exists
	$(SYMFONY_BO) doctrine:database:create --if-not-exists --connection=pool

db-make-migration: ## 📜 Generate a new migration
	$(SYMFONY_BO) doctrine:migrations:diff

db-migrate: ## 🔄 Execute all migrations
	$(SYMFONY_BO) doctrine:migrations:migrate -n
	$(SYMFONY_BO) doctrine:migrations:migrate -n --em=pool --configuration=migrations/Datapool/doctrine_migrations.yaml

db-fixtures: ## 🧪 Load database fixtures
	$(SYMFONY_BO) doctrine:fixtures:load -n

db-full: db-create db-migrate db-fixtures ## 🏗 Create DB, run migrations, and load fixtures

## ----------------
## ✅ Tests
## ----------------
define run_phpunit
	$(1) vendor/bin/phpunit $(ARG)
endef

api-test-unit: ## 🧪 Run unit tests for API
	$(call run_phpunit,$(EXEC_API) --testsuite unit)

api-test-integration: ## 🛠 Run integration tests for API
	$(call run_phpunit,$(EXEC_API) --testsuite api)

api-test-all: ## 🚀 Run all API tests
	$(call run_phpunit,$(EXEC_API))

api-test-coverage: ## 📊 Test coverage for API - you may need "apt install wslu"
	$(EXEC_API) vendor/bin/phpunit --coverage-html tests/coverage
	wslview ./dataviz-api/tests/coverage/index.html

bo-test-integration: ## 🛠 Run integration tests for BO
	$(call run_phpunit,$(EXEC_BO) --testsuite api)

bo-test-all: ## 🚀 Run all BO tests
	$(call run_phpunit,$(EXEC_BO))

bo-test-coverage: ## 📊 Test coverage for BO - you may need "apt install wslu"
	$(EXEC_BO) vendor/bin/phpunit --coverage-html tests/coverage
	wslview ./dataviz-bo-api/tests/coverage/index.html

front-test-all: ## 🚀 Run all frontend tests
	$(EXEC_FRONT) yarn test

front-test-coverage: ## 📊 Test coverage for frontend
	$(EXEC_FRONT) yarn test-coverage

test: bo-test-all api-test-all front-test-all ## 🚀 Run all tests (API + BO + FRONT)
	
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

apply-bo-csfixer: ## 🎨 Fix PHP code style for BO
	$(EXEC_BO) vendor/bin/php-cs-fixer fix --using-cache=no --verbose --diff
	$(EXEC_BO) vendor/bin/php-cs-fixer fix ./tests --using-cache=no --verbose --diff

phpstan-bo: ## 🔍 Run static analysis on PHP code for BO
	$(EXEC_BO) vendor/bin/phpstan analyse src
	
front-lint:
	$(EXEC_FRONT) yarn lint:fix

front-format:
	$(EXEC_FRONT) yarn run format

## ----------------
## 📜 Help
## ----------------
.PHONY: build start stop vendor test php-cs-fixer apply-php-cs-fixer help

.DEFAULT_GOAL := help
help:
	@echo "\n\033[1;36mAvailable commands:\033[0m"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
