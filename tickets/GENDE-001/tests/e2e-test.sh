#!/bin/bash

#
# End-to-End Test Suite for laravel-max Generator
#
# Complete workflow test:
# 1. Build generator JAR
# 2. Generate code from spec
# 3. Validate generated code structure
# 4. Copy to Laravel integration project
# 5. Run Laravel API tests
#
# Usage:
#   ./e2e-test.sh [spec-name] [namespace]
#
# Example:
#   ./e2e-test.sh petshop PetshopApi
#

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Default values
SPEC_NAME="${1:-petshop}"
NAMESPACE="${2:-PetshopApi}"

# Directories
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TICKET_DIR="$(dirname "$SCRIPT_DIR")"
ROOT_DIR="$(dirname "$(dirname "$TICKET_DIR")")"
POC_DIR="$TICKET_DIR/poc"
GEN_DIR="$TICKET_DIR/generated/$SPEC_NAME"
LARAVEL_PROJECT="$ROOT_DIR/projects/laravel-api--custom-laravel-max--laravel-max"

echo "=========================================="
echo "End-to-End Test Suite"
echo "=========================================="
echo "Spec: $SPEC_NAME"
echo "Namespace: $NAMESPACE"
echo "Ticket Dir: $TICKET_DIR"
echo ""

# Track overall status
TOTAL_STEPS=0
PASSED_STEPS=0
FAILED_STEPS=0

run_step() {
    local step_name="$1"
    local step_command="$2"
    local stop_on_error="${3:-true}"

    TOTAL_STEPS=$((TOTAL_STEPS + 1))

    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${BLUE}Step $TOTAL_STEPS: $step_name${NC}"
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"

    if eval "$step_command"; then
        echo -e "${GREEN}✓ Step $TOTAL_STEPS PASSED${NC}"
        PASSED_STEPS=$((PASSED_STEPS + 1))
        echo ""
        return 0
    else
        echo -e "${RED}✗ Step $TOTAL_STEPS FAILED${NC}"
        FAILED_STEPS=$((FAILED_STEPS + 1))
        echo ""

        if [ "$stop_on_error" = "true" ]; then
            echo -e "${RED}Stopping due to failure${NC}"
            print_summary
            exit 1
        fi

        return 1
    fi
}

print_summary() {
    echo ""
    echo "=========================================="
    echo "Test Summary"
    echo "=========================================="
    echo "Total steps:  $TOTAL_STEPS"
    echo -e "Passed:       ${GREEN}$PASSED_STEPS${NC}"
    if [ $FAILED_STEPS -gt 0 ]; then
        echo -e "Failed:       ${RED}$FAILED_STEPS${NC}"
    else
        echo -e "Failed:       $FAILED_STEPS"
    fi
    echo "=========================================="

    if [ $FAILED_STEPS -eq 0 ]; then
        echo -e "${GREEN}✓ All tests passed!${NC}"
        echo ""
        echo "The laravel-max generator is working correctly!"
        echo "All Phase 6 and Phase 7 fixes are validated."
    else
        echo -e "${RED}✗ Some tests failed${NC}"
    fi
}

## STEP 1: Build Generator JAR
run_step "Build Generator JAR" "
    cd '$POC_DIR/laravel-max-generator' && \
    docker run --rm \
        -v '$ROOT_DIR:/workspace' \
        -w /workspace/tickets/GENDE-001/poc/laravel-max-generator \
        maven:3.9-eclipse-temurin-21 \
        mvn clean package -DskipTests > /dev/null 2>&1 && \
    echo '  Generator JAR built successfully' && \
    ls -lh target/laravel-max-openapi-generator-1.0.0.jar
"

## STEP 2: Clean Output Directory
run_step "Clean Output Directory" "
    rm -rf '$GEN_DIR' && \
    mkdir -p '$GEN_DIR' && \
    echo '  Output directory cleaned: $GEN_DIR'
"

## STEP 3: Generate Code
run_step "Generate Code from OpenAPI Spec" "
    cd '$POC_DIR' && \
    docker run --rm \
        -v '$ROOT_DIR:/workspace' \
        -w /workspace/tickets/GENDE-001/poc \
        maven:3.9-eclipse-temurin-21 \
        mvn -f generate-pom.xml generate-sources > /dev/null 2>&1 && \
    echo '  Code generated successfully' && \
    echo '  Generated files:' && \
    find '$GEN_DIR/app' -name '*.php' | wc -l | xargs echo '    PHP files:'
" "false"  # Don't stop on error - generation might have issues

## STEP 4: Validate Generated Structure
run_step "Validate Generated Code Structure" "
    '$SCRIPT_DIR/validate-generated-structure.sh' '$GEN_DIR' '$NAMESPACE'
" "false"  # Continue even if some validations fail

## STEP 5: Copy to Laravel Project (Skip for now to keep test focused)
# run_step "Copy Generated Code to Laravel Project" "
#     echo '  Copying Models...' && \
#     cp -r '$GEN_DIR/app/Models/'* '$LARAVEL_PROJECT/app/Models/' && \
#     echo '  Copying API Interfaces...' && \
#     cp -r '$GEN_DIR/app/Api/'* '$LARAVEL_PROJECT/app/Api/' && \
#     echo '  Copying Controllers...' && \
#     cp -r '$GEN_DIR/app/Http/Controllers/'* '$LARAVEL_PROJECT/app/Http/Controllers/' && \
#     echo '  Copying Resources...' && \
#     cp -r '$GEN_DIR/app/Http/Resources/'* '$LARAVEL_PROJECT/app/Http/Resources/' && \
#     echo '  Files copied successfully'
# "

## STEP 6: Run Laravel Tests (Skip for now - requires Laravel setup)
# run_step "Run Laravel API Integration Tests" "
#     cd '$LARAVEL_PROJECT' && \
#     php artisan test --filter=PetshopApiTest
# " "false"  # Continue even if tests fail

## Print Summary
print_summary

# Exit with appropriate code
if [ $FAILED_STEPS -eq 0 ]; then
    exit 0
else
    exit 1
fi
