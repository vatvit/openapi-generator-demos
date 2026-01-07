.PHONY: help install test phpstan phpcs phpcbf analyse lint clean

# Default target
help:
	@echo "Available commands:"
	@echo "  make install   - Install composer dependencies"
	@echo "  make test      - Run PHPUnit tests"
	@echo "  make phpstan   - Run PHPStan static analysis"
	@echo "  make phpcs     - Run PHP_CodeSniffer"
	@echo "  make phpcbf    - Run PHP_CodeSniffer auto-fixer"
	@echo "  make analyse   - Run all static analysis (phpstan + phpcs)"
	@echo "  make lint      - Run PHP syntax check"
	@echo "  make clean     - Clean generated files"

# Install dependencies
install:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/slim-api--slim-max--integration-tests \
		composer:latest \
		composer install --no-interaction

# Run PHPUnit tests
test:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/slim-api--slim-max--integration-tests \
		php:8.4-cli \
		vendor/bin/phpunit

# Run PHPStan static analysis
phpstan:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/slim-api--slim-max--integration-tests \
		php:8.4-cli \
		vendor/bin/phpstan analyse --memory-limit=512M

# Run PHP_CodeSniffer
phpcs:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/slim-api--slim-max--integration-tests \
		php:8.4-cli \
		vendor/bin/phpcs

# Run PHP_CodeSniffer auto-fixer
phpcbf:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/slim-api--slim-max--integration-tests \
		php:8.4-cli \
		vendor/bin/phpcbf

# Run all static analysis
analyse: phpstan phpcs

# Run PHP syntax check
lint:
	docker run --rm \
		-v $$(pwd)/../..:/local \
		-w /local/projects/slim-api--slim-max--integration-tests \
		php:8.4-cli \
		sh -c 'find ../../generated/php-max-slim -name "*.php" -exec php -l {} \;'

# Clean generated files
clean:
	rm -rf vendor
	rm -rf .phpunit.cache
	rm -f composer.lock
