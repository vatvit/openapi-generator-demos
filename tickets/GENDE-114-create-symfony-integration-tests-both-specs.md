---
code: GENDE-114
status: Proposed
dateCreated: 2026-01-07T16:41:34.431Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 3: Symfony
relatedTickets: GENDE-088,GENDE-113
dependsOn: GENDE-113
---

# Create Symfony integration tests (both specs)

## 1. Description

Create PHPUnit functional tests for both TicTacToe and Petshop APIs in Symfony.

## 2. Rationale

Functional tests verify Symfony integration works end-to-end.

## 3. Solution Analysis

### Symfony Test Pattern
```php
class CreatePetTest extends WebTestCase
{
    public function testCreatePet(): void
    {
        $client = static::createClient();
        $client->request('POST', '/pets', [], [], 
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['name' => 'Fluffy'])
        );
        
        $this->assertResponseStatusCodeSame(201);
    }
}
```

## 4. Implementation Specification

### Test Files
```
tests/Functional/
├── Tictactoe/
│   └── GameTest.php
└── Petshop/
    ├── PetTest.php
    └── ...
```

## 5. Acceptance Criteria

- [ ] Tests for all operations
- [ ] Happy path tested
- [ ] Validation tested
- [ ] All tests pass