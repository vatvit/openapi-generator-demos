---
code: GENDE-014
status: Implemented
dateCreated: 2026-01-01T14:07:33.176Z
type: Feature Enhancement
priority: Low
relatedTickets: GENDE-003
dependsOn: GENDE-012
implementationNotes: Integration tests for custom templates demo project
---

# Add Integration Tests for Symfony Demo Project

## 1. Description

### Problem Statement

Laravel demo project has integration tests validating generated code works correctly. Symfony demo project needs equivalent test coverage.

### Goal

Create integration tests for the Symfony demo project that:
1. Validate API endpoints respond correctly
2. Test request validation (Symfony Validator)
3. Test response structure matches OpenAPI spec
4. Test error handling
5. Cover both TicTacToe and PetShop APIs

### Scope

- PHPUnit integration tests
- API endpoint tests using Symfony test client
- Validation tests
- Error response tests

## 2. Rationale

- **Parity with Laravel** - Laravel demo has tests, Symfony should too
- **Quality assurance** - Proves generated code works correctly
- **Regression prevention** - Catch issues when templates change
- **Documentation** - Tests show expected behavior

## 3. Solution Analysis

### Test Categories

| Category | Description | Priority |
|----------|-------------|----------|
| Endpoint availability | Routes respond with correct status | High |
| Request validation | Invalid input returns 400/422 | High |
| Response structure | JSON matches OpenAPI schema | Medium |
| Authentication | Security endpoints require auth | Medium |
| Error responses | Errors follow spec format | Medium |

### Test Structure

```
tests/
├── Api/
│   ├── TicTacToe/
│   │   ├── GameManagementTest.php
│   │   ├── GameplayTest.php
│   │   └── StatisticsTest.php
│   └── PetShop/
│       ├── PetTest.php
│       └── StoreTest.php
└── bootstrap.php
```

### Symfony Test Approach

```php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameManagementTest extends WebTestCase
{
    public function testCreateGameRequiresAuthentication(): void
    {
        $client = static::createClient();
        $client->request('POST', '/games', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode(['mode' => 'pvp']));
        
        $this->assertResponseStatusCodeSame(401);
    }
    
    public function testCreateGameValidatesInput(): void
    {
        $client = static::createClient();
        $client->request('POST', '/games', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer test-token'
        ], json_encode(['mode' => 'invalid']));
        
        $this->assertResponseStatusCodeSame(400);
    }
}
```

## 4. Implementation Specification

### Steps

1. **Setup PHPUnit**
   ```bash
   composer require --dev phpunit/phpunit symfony/test-pack
   ```

2. **Create test base class**
   - Common setup/teardown
   - Helper methods for API calls
   - Authentication helpers

3. **Write TicTacToe tests**
   - GameManagement: create, get, list, delete
   - Gameplay: getBoard, putSquare, getMoves
   - Statistics: leaderboard, playerStats

4. **Write PetShop tests**
   - Pet: add, get, update, delete, findByStatus
   - Store: inventory, order

5. **Add to Makefile**
   ```makefile
   test:
       docker-compose exec app ./vendor/bin/phpunit
   
   test-coverage:
       docker-compose exec app ./vendor/bin/phpunit --coverage-html coverage/
   ```

### Test Count Target

Based on Laravel demo (18 tests, 42 assertions):
- TicTacToe: ~12 tests
- PetShop: ~8 tests
- Total: ~20 tests

### Deliverables

| Artifact | Location |
|----------|----------|
| PHPUnit config | `phpunit.xml` |
| Test bootstrap | `tests/bootstrap.php` |
| TicTacToe tests | `tests/Api/TicTacToe/` |
| PetShop tests | `tests/Api/PetShop/` |
| Makefile targets | `test`, `test-coverage` |

## 5. Acceptance Criteria

- [ ] PHPUnit configured and working
- [ ] At least 15 integration tests written
- [ ] Tests cover both TicTacToe and PetShop APIs
- [ ] All tests pass with `make test`
- [ ] Tests validate request validation works
- [ ] Tests validate response structure
- [ ] Test coverage documented