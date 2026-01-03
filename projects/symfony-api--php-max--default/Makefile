.PHONY: help setup start stop logs test shell generate dumpautoload

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

setup: ## Install dependencies and setup Symfony
	docker-compose build
	docker-compose run --rm app composer install
	@echo "Setup complete. Run 'make start' to start the application."

start: ## Start all Docker services
	docker-compose up -d
	@echo "Application running at http://localhost:8002"

stop: ## Stop all Docker services
	docker-compose down

logs: ## View application logs
	docker-compose logs -f app

test: ## Run PHPUnit tests
	docker-compose exec app bin/phpunit

shell: ## Open shell in app container
	docker-compose exec app bash

dumpautoload: ## Refresh composer autoload
	docker-compose exec app composer dump-autoload

generate: ## Regenerate API code from specs
	docker run --rm -v "$$(pwd)/../..:/local" openapitools/openapi-generator-cli:v7.12.0 generate \
		-g php-symfony \
		-i /local/openapi-generator-specs/tictactoe/tictactoe.json \
		-o /local/projects/symfony-api--php-symfony--default/generated/tictactoe \
		-c /local/projects/symfony-api--php-symfony--default/openapi-generator-configs/tictactoe-config.json
	docker run --rm -v "$$(pwd)/../..:/local" openapitools/openapi-generator-cli:v7.12.0 generate \
		-g php-symfony \
		-i /local/openapi-generator-specs/petshop/petshop-extended.yaml \
		-o /local/projects/symfony-api--php-symfony--default/generated/petshop \
		-c /local/projects/symfony-api--php-symfony--default/openapi-generator-configs/petshop-config.json
	$(MAKE) dumpautoload

cache-clear: ## Clear Symfony cache
	docker-compose exec app bin/console cache:clear

routes: ## List all routes
	docker-compose exec app bin/console debug:router
