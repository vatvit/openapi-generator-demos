.PHONY: help setup start stop logs test-phpunit dumpautoload shell generate build-generator

GENERATOR_DIR := ../../openapi-generator-generators/php-max
GENERATOR_JAR := $(GENERATOR_DIR)/target/php-max-openapi-generator-1.0.0.jar
CLI_JAR := $(GENERATOR_DIR)/target/openapi-generator-cli-7.18.0.jar

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

setup: ## Install dependencies and setup Laravel
	docker-compose build
	docker-compose run --rm app composer install
	docker-compose run --rm app cp -n .env.example .env || true
	docker-compose run --rm app php artisan key:generate
	@echo "Setup complete. Run 'make start' to start the application."

start: ## Start all Docker services
	docker-compose up -d
	@echo "Application running at http://localhost:8002"

stop: ## Stop all Docker services
	docker-compose down

logs: ## View application logs
	docker-compose logs -f app

test-phpunit: ## Run PHPUnit tests
	docker-compose exec app php artisan test

dumpautoload: ## Refresh composer autoload
	docker-compose exec app composer dump-autoload

shell: ## Open shell in app container
	docker-compose exec app bash

build-generator: ## Build the php-max generator
	cd $(GENERATOR_DIR) && make build

generate: ## Regenerate API code from specs using php-max generator
	@if [ ! -f "$(GENERATOR_JAR)" ]; then \
		echo "Generator JAR not found. Building..."; \
		$(MAKE) build-generator; \
	fi
	@if [ ! -f "$(CLI_JAR)" ]; then \
		echo "Downloading OpenAPI Generator CLI..."; \
		cd $(GENERATOR_DIR) && make download-cli; \
	fi
	@echo "Generating TicTacToe API with php-max (laravel-max)..."
	@mkdir -p generated/tictactoe
	docker run --rm \
		-v "$$(pwd)/$(GENERATOR_DIR):/generator" \
		-v "$$(pwd)/../..:/local" \
		-w /local \
		eclipse-temurin:17-jdk \
		java -cp /generator/target/openapi-generator-cli-7.18.0.jar:/generator/target/php-max-openapi-generator-1.0.0.jar \
			org.openapitools.codegen.OpenAPIGenerator generate \
			-g laravel-max \
			-i /local/openapi-generator-specs/tictactoe/tictactoe.json \
			-o /local/projects/laravel-api--php-max--default/generated/tictactoe \
			--additional-properties=invokerPackage=TicTacToeApi
	@echo "Generation complete. Run 'make dumpautoload' to refresh autoload."
