#!/bin/bash

#
# PHP Syntax Validation Script
#
# Validates all generated PHP files for:
# - Syntax errors
# - Correct namespace usage
# - Proper strict_types placement
#
# Usage:
#   ./validate-php-syntax.sh <generated-code-directory>
#
# Example:
#   ./validate-php-syntax.sh ../generated/petshop
#

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counters
TOTAL_FILES=0
PASSED_FILES=0
FAILED_FILES=0

# Expected namespace (default)
EXPECTED_NAMESPACE="PetshopApi"

# Parse arguments
if [ $# -lt 1 ]; then
    echo "Usage: $0 <generated-code-directory> [expected-namespace]"
    echo "Example: $0 ../generated/petshop PetshopApi"
    exit 1
fi

GEN_DIR="$1"
if [ $# -ge 2 ]; then
    EXPECTED_NAMESPACE="$2"
fi

if [ ! -d "$GEN_DIR" ]; then
    echo -e "${RED}ERROR: Directory not found: $GEN_DIR${NC}"
    exit 1
fi

echo "=========================================="
echo "PHP Syntax Validation"
echo "=========================================="
echo "Directory: $GEN_DIR"
echo "Expected Namespace: $EXPECTED_NAMESPACE"
echo ""

# Find all PHP files
echo "Finding PHP files..."
PHP_FILES=$(find "$GEN_DIR/app" -name "*.php" -type f 2>/dev/null || true)

if [ -z "$PHP_FILES" ]; then
    echo -e "${RED}ERROR: No PHP files found in $GEN_DIR/app${NC}"
    exit 1
fi

TOTAL_FILES=$(echo "$PHP_FILES" | wc -l | tr -d ' ')
echo "Found $TOTAL_FILES PHP files"
echo ""

# Validation functions
validate_syntax() {
    local file="$1"
    # Use Docker if PHP not available locally
    if command -v php &> /dev/null; then
        php -l "$file" > /dev/null 2>&1
        return $?
    else
        # Use PHP Docker image
        docker run --rm -v "$(dirname "$file"):/code" php:8.4-cli php -l "/code/$(basename "$file")" > /dev/null 2>&1
        return $?
    fi
}

validate_strict_types() {
    local file="$1"
    # First line should be <?php declare(strict_types=1);
    local first_line=$(head -n 1 "$file")
    if [[ "$first_line" == "<?php declare(strict_types=1);" ]]; then
        return 0
    else
        echo "  ✗ First line must be '<?php declare(strict_types=1);', got: $first_line"
        return 1
    fi
}

validate_namespace() {
    local file="$1"
    # Should contain expected namespace
    if grep -q "namespace $EXPECTED_NAMESPACE" "$file"; then
        return 0
    else
        echo "  ✗ Missing namespace: $EXPECTED_NAMESPACE"
        return 1
    fi
}

validate_no_app_namespace() {
    local file="$1"
    # Should NOT have 'namespace App\' (except for Illuminate imports)
    if grep -q "^namespace App\\\\" "$file"; then
        echo "  ✗ Found forbidden 'namespace App\\' declaration"
        return 1
    else
        return 0
    fi
}

# Validate each file
echo "Validating files..."
echo ""

for file in $PHP_FILES; do
    TOTAL_FILES=$((TOTAL_FILES))
    RELATIVE_PATH="${file#$GEN_DIR/}"

    # Run validations
    ERRORS=0

    # 1. PHP Syntax
    if ! validate_syntax "$file"; then
        echo -e "${RED}✗ FAIL:${NC} $RELATIVE_PATH"
        echo "  ✗ PHP syntax error"
        ERRORS=$((ERRORS + 1))
    fi

    # 2. Strict types placement
    if ! validate_strict_types "$file"; then
        if [ $ERRORS -eq 0 ]; then
            echo -e "${RED}✗ FAIL:${NC} $RELATIVE_PATH"
        fi
        ERRORS=$((ERRORS + 1))
    fi

    # 3. Namespace check
    if ! validate_namespace "$file"; then
        if [ $ERRORS -eq 0 ]; then
            echo -e "${RED}✗ FAIL:${NC} $RELATIVE_PATH"
        fi
        ERRORS=$((ERRORS + 1))
    fi

    # 4. No App namespace
    if ! validate_no_app_namespace "$file"; then
        if [ $ERRORS -eq 0 ]; then
            echo -e "${RED}✗ FAIL:${NC} $RELATIVE_PATH"
        fi
        ERRORS=$((ERRORS + 1))
    fi

    # Report result
    if [ $ERRORS -eq 0 ]; then
        echo -e "${GREEN}✓ PASS:${NC} $RELATIVE_PATH"
        PASSED_FILES=$((PASSED_FILES + 1))
    else
        FAILED_FILES=$((FAILED_FILES + 1))
        echo ""
    fi
done

echo ""
echo "=========================================="
echo "Summary"
echo "=========================================="
echo "Total files:  $TOTAL_FILES"
echo -e "Passed:       ${GREEN}$PASSED_FILES${NC}"
if [ $FAILED_FILES -gt 0 ]; then
    echo -e "Failed:       ${RED}$FAILED_FILES${NC}"
else
    echo -e "Failed:       $FAILED_FILES"
fi
echo "=========================================="

if [ $FAILED_FILES -eq 0 ]; then
    echo -e "${GREEN}✓ All tests passed!${NC}"
    exit 0
else
    echo -e "${RED}✗ Some tests failed${NC}"
    exit 1
fi
