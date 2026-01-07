.PHONY: help install test phpstan phpcs phpcbf analyse lint clean generate

# Project name for paths
PROJECT_NAME := laravel-api--php-adaptive--integration-tests
GENERATOR_PATH := ../../openapi-generator-generators/php-adaptive

# Default target
help:
	@echo "PHP-Adaptive Integration Tests"
	@echo "=============================="
	@echo ""
	@echo "Available commands:"
	@echo "  make generate  - Generate libraries from OpenAPI specs"
	@echo "  make install   - Install composer dependencies"
	@echo "  make test      - Run PHPUnit tests"
	@echo "  make phpstan   - Run PHPStan static analysis (level 6)"
	@echo "  make phpcs     - Run PHP_CodeSniffer"
	@echo "  make phpcbf    - Run PHP_CodeSniffer auto-fixer"
	@echo "  make analyse   - Run all static analysis (phpstan + phpcs)"
	@echo "  make lint      - Run PHP syntax check"
	@echo "  make clean     - Clean generated files"
	@echo ""
	@echo "Quick start:"
	@echo "  1. make generate  - Generate TicTacToe and Petshop libraries"
	@echo "  2. make install   - Install PHP dependencies"
	@echo "  3. make test      - Run tests"

# Generate libraries using php-adaptive generator
generate:
	@echo "Generating TicTacToe library..."
	cd $(GENERATOR_PATH) && make generate \
		SPEC=openapi-generator-specs/tictactoe/tictactoe.json \
		OUTPUT_DIR=generated/php-adaptive/tictactoe \
		INVOKER=TicTacToeApi
	@echo "Generating Petshop library..."
	cd $(GENERATOR_PATH) && make generate \
		SPEC=openapi-generator-specs/petshop/petshop-extended.yaml \
		OUTPUT_DIR=generated/php-adaptive/petshop \
		INVOKER=PetshopApi
	@echo "Libraries generated successfully!"

# Install dependencies
install:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/$(PROJECT_NAME) \
		composer:latest \
		composer update --no-interaction

# Run PHPUnit tests
test:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/$(PROJECT_NAME) \
		php:8.4-cli \
		vendor/bin/phpunit

# Run PHPStan static analysis
phpstan:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/$(PROJECT_NAME) \
		php:8.4-cli \
		vendor/bin/phpstan analyse --memory-limit=512M

# Run PHP_CodeSniffer
phpcs:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/$(PROJECT_NAME) \
		php:8.4-cli \
		vendor/bin/phpcs

# Run PHP_CodeSniffer auto-fixer
phpcbf:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/$(PROJECT_NAME) \
		php:8.4-cli \
		vendor/bin/phpcbf

# Run all static analysis
analyse: phpstan phpcs

# Run PHP syntax check on generated code
lint:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/$(PROJECT_NAME) \
		php:8.4-cli \
		sh -c 'find ../../generated/php-adaptive -name "*.php" -exec php -l {} \;'

# Clean generated files
clean:
	rm -rf vendor
	rm -rf .phpunit.cache
	rm -f composer.lock
