.PHONY: help install test test-verbose dumpautoload

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-20s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Install dependencies via Docker
	docker run --rm -v $(PWD):/app -w /app composer:latest install --ignore-platform-reqs

test: ## Run PHPUnit tests via Docker
	docker run --rm -v $(PWD):/app -v $(PWD)/../../generated/laravel-max/tictactoe:/app/../../generated/laravel-max/tictactoe -w /app php:8.4-cli sh -c "mkdir -p /app/bootstrap/cache /app/storage/framework/sessions /app/storage/framework/views /app/storage/framework/cache /app/storage/logs && chmod -R 777 /app/bootstrap /app/storage && php vendor/bin/phpunit"

test-verbose: ## Run PHPUnit tests with verbose output
	docker run --rm -v $(PWD):/app -v $(PWD)/../../generated/laravel-max/tictactoe:/app/../../generated/laravel-max/tictactoe -w /app php:8.4-cli sh -c "mkdir -p /app/bootstrap/cache /app/storage/framework/sessions /app/storage/framework/views /app/storage/framework/cache /app/storage/logs && chmod -R 777 /app/bootstrap /app/storage && php vendor/bin/phpunit --testdox"

dumpautoload: ## Refresh composer autoload files
	docker run --rm -v $(PWD):/app -w /app composer:latest dump-autoload
