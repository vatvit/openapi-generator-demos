#!/bin/bash

#
# Generated Code Structure Validation Script
#
# Performs fast static analysis without requiring PHP:
# - Correct namespace usage
# - Proper strict_types placement
# - File structure validation
# - No project-specific code (Handlers/Providers)
#
# Usage:
#   ./validate-generated-structure.sh <generated-code-directory> <expected-namespace>
#
# Example:
#   ./validate-generated-structure.sh ../generated/petshop PetshopApi
#

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counters
TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

# Parse arguments
if [ $# -lt 2 ]; then
    echo "Usage: $0 <generated-code-directory> <expected-namespace>"
    echo "Example: $0 ../generated/petshop PetshopApi"
    exit 1
fi

GEN_DIR="$1"
EXPECTED_NAMESPACE="$2"

if [ ! -d "$GEN_DIR" ]; then
    echo -e "${RED}ERROR: Directory not found: $GEN_DIR${NC}"
    exit 1
fi

echo "=========================================="
echo "Generated Code Structure Validation"
echo "=========================================="
echo "Directory: $GEN_DIR"
echo "Expected Namespace: $EXPECTED_NAMESPACE"
echo ""

# Test function
run_test() {
    local test_name="$1"
    local test_command="$2"

    TOTAL_TESTS=$((TOTAL_TESTS + 1))

    if eval "$test_command"; then
        echo -e "${GREEN}✓ PASS:${NC} $test_name"
        PASSED_TESTS=$((PASSED_TESTS + 1))
        return 0
    else
        echo -e "${RED}✗ FAIL:${NC} $test_name"
        FAILED_TESTS=$((FAILED_TESTS + 1))
        return 1
    fi
}

## STRUCTURE TESTS

run_test "Has Models directory" "[ -d '$GEN_DIR/app/Models' ]"
run_test "Has Api directory" "[ -d '$GEN_DIR/app/Api' ]"
run_test "Has Controllers directory" "[ -d '$GEN_DIR/app/Http/Controllers' ]"
run_test "Has Resources directory" "[ -d '$GEN_DIR/app/Http/Resources' ]"
run_test "Has Routes directory" "[ -d '$GEN_DIR/routes' ]"

run_test "Does NOT have Handlers directory (project-specific)" "[ ! -d '$GEN_DIR/app/Handlers' ]"
run_test "Does NOT have Providers directory (project-specific)" "[ ! -d '$GEN_DIR/app/Providers' ]"

## FILE COUNT TESTS

MODEL_COUNT=$(find "$GEN_DIR/app/Models" -name "*.php" -type f 2>/dev/null | wc -l | tr -d ' ')
run_test "Has Model files (found $MODEL_COUNT)" "[ $MODEL_COUNT -gt 0 ]"

API_COUNT=$(find "$GEN_DIR/app/Api" -name "*Api.php" -type f 2>/dev/null | wc -l | tr -d ' ')
run_test "Has API interface files (found $API_COUNT)" "[ $API_COUNT -gt 0 ]"

CONTROLLER_COUNT=$(find "$GEN_DIR/app/Http/Controllers" -name "*Controller.php" -type f 2>/dev/null | wc -l | tr -d ' ')
run_test "Has Controller files (found $CONTROLLER_COUNT)" "[ $CONTROLLER_COUNT -gt 0 ]"

RESOURCE_COUNT=$(find "$GEN_DIR/app/Http/Resources" -name "*Resource.php" -type f 2>/dev/null | wc -l | tr -d ' ')
run_test "Has Resource files (found $RESOURCE_COUNT)" "[ $RESOURCE_COUNT -gt 0 ]"

## NAMESPACE TESTS

echo ""
echo "Checking namespaces..."

# All PHP files should use correct namespace
PHP_FILES=$(find "$GEN_DIR/app" -name "*.php" -type f)
NAMESPACE_ERRORS=0

for file in $PHP_FILES; do
    # Check for expected namespace
    if ! grep -q "namespace $EXPECTED_NAMESPACE" "$file"; then
        if [ $NAMESPACE_ERRORS -eq 0 ]; then
            echo -e "${RED}  Files missing $EXPECTED_NAMESPACE namespace:${NC}"
        fi
        echo "    - $(basename $file)"
        NAMESPACE_ERRORS=$((NAMESPACE_ERRORS + 1))
    fi

    # Check for forbidden App namespace
    if grep -q "^namespace App\\\\" "$file"; then
        if [ $NAMESPACE_ERRORS -eq 0 ]; then
            echo -e "${RED}  Files with forbidden 'namespace App\\' :${NC}"
        fi
        echo "    - $(basename $file)"
        NAMESPACE_ERRORS=$((NAMESPACE_ERRORS + 1))
    fi
done

run_test "All files use correct namespace" "[ $NAMESPACE_ERRORS -eq 0 ]"

## STRICT TYPES TESTS

echo ""
echo "Checking strict_types declarations..."

STRICT_TYPES_ERRORS=0

for file in $PHP_FILES; do
    first_line=$(head -n 1 "$file")
    if [[ ! "$first_line" =~ "<?php declare(strict_types=1);" ]]; then
        if [ $STRICT_TYPES_ERRORS -eq 0 ]; then
            echo -e "${RED}  Files with incorrect first line:${NC}"
        fi
        echo "    - $(basename $file): $first_line"
        STRICT_TYPES_ERRORS=$((STRICT_TYPES_ERRORS + 1))
    fi
done

run_test "All files start with <?php declare(strict_types=1);" "[ $STRICT_TYPES_ERRORS -eq 0 ]"

## PHASE 7 FIX VALIDATION

echo ""
echo "Checking Phase 7 fixes..."

# Fix #1: Controllers include Request parameter
CONTROLLER_FILES=$(find "$GEN_DIR/app/Http/Controllers" -name "*Controller.php" -type f)
CONTROLLER_ERRORS=0

for file in $CONTROLLER_FILES; do
    if ! grep -q "use Illuminate\\\\Http\\\\Request;" "$file"; then
        if [ $CONTROLLER_ERRORS -eq 0 ]; then
            echo -e "${RED}  Controllers missing Request import:${NC}"
        fi
        echo "    - $(basename $file)"
        CONTROLLER_ERRORS=$((CONTROLLER_ERRORS + 1))
    fi

    if ! grep -q "Request \$request" "$file"; then
        if [ $CONTROLLER_ERRORS -eq 0 ]; then
            echo -e "${RED}  Controllers missing Request parameter:${NC}"
        fi
        echo "    - $(basename $file)"
        CONTROLLER_ERRORS=$((CONTROLLER_ERRORS + 1))
    fi
done

run_test "Phase 7 Fix #1: Controllers include Request parameter" "[ $CONTROLLER_ERRORS -eq 0 ]"

# Fix #2: Array resources use array_map
if [ -f "$GEN_DIR/app/Http/Resources/FindPets200Resource.php" ]; then
    run_test "Phase 7 Fix #2: Array resources use array_map()" \
        "grep -q 'array_map' '$GEN_DIR/app/Http/Resources/FindPets200Resource.php'"
fi

# Fix #3: Error resources use dynamic status
ERROR_RESOURCES=$(find "$GEN_DIR/app/Http/Resources" -name "*0Resource.php" -type f)
ERROR_RESOURCE_ERRORS=0

for file in $ERROR_RESOURCES; do
    if grep -q '\$httpCode = 0' "$file"; then
        if [ $ERROR_RESOURCE_ERRORS -eq 0 ]; then
            echo -e "${RED}  Error resources with hardcoded status 0:${NC}"
        fi
        echo "    - $(basename $file)"
        ERROR_RESOURCE_ERRORS=$((ERROR_RESOURCE_ERRORS + 1))
    fi

    if ! grep -q '\$model->code' "$file"; then
        if [ $ERROR_RESOURCE_ERRORS -eq 0 ]; then
            echo -e "${RED}  Error resources not using dynamic status:${NC}"
        fi
        echo "    - $(basename $file)"
        ERROR_RESOURCE_ERRORS=$((ERROR_RESOURCE_ERRORS + 1))
    fi
done

run_test "Phase 7 Fix #3: Error resources use dynamic status" "[ $ERROR_RESOURCE_ERRORS -eq 0 ]"

## SUMMARY

echo ""
echo "=========================================="
echo "Summary"
echo "=========================================="
echo "Total tests:  $TOTAL_TESTS"
echo -e "Passed:       ${GREEN}$PASSED_TESTS${NC}"
if [ $FAILED_TESTS -gt 0 ]; then
    echo -e "Failed:       ${RED}$FAILED_TESTS${NC}"
else
    echo -e "Failed:       $FAILED_TESTS"
fi
echo "=========================================="

if [ $FAILED_TESTS -eq 0 ]; then
    echo -e "${GREEN}✓ All tests passed!${NC}"
    exit 0
else
    echo -e "${RED}✗ Some tests failed${NC}"
    exit 1
fi
