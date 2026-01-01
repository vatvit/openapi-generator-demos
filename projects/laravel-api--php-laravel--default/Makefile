.PHONY: help setup start stop logs test-phpunit dumpautoload shell generate

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
	@echo "Application running at http://localhost:8001"

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

generate: ## Regenerate API code from specs (uses config files for proper namespaces)
	docker run --rm -v "$$(pwd)/../..:/local" openapitools/openapi-generator-cli:v7.12.0 generate \
		-g php-laravel \
		-i /local/openapi-generator-specs/tictactoe/tictactoe.json \
		-o /local/projects/laravel-api--php-laravel--default/generated/tictactoe \
		-c /local/projects/laravel-api--php-laravel--default/openapi-generator-configs/tictactoe-config.json
	docker run --rm -v "$$(pwd)/../..:/local" openapitools/openapi-generator-cli:v7.12.0 generate \
		-g php-laravel \
		-i /local/openapi-generator-specs/petshop/petshop-extended.yaml \
		-o /local/projects/laravel-api--php-laravel--default/generated/petshop \
		-c /local/projects/laravel-api--php-laravel--default/openapi-generator-configs/petshop-config.json
	$(MAKE) dumpautoload
