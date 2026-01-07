---
code: GENDE-129
status: Implemented
dateCreated: 2026-01-07T21:38:28.520Z
type: Feature Enhancement
priority: Medium
phaseEpic: Phase 2: Laravel
dependsOn: GENDE-093
---

# Expand controller generation tests for comprehensive coverage

## 1. Description

Expand existing controller generation tests to cover more scenarios and add Petshop coverage.

## 2. Rationale

Current tests only verify class existence. Need to verify:
- Constructor injection type
- __invoke method parameters
- Operations with path params
- Operations with query params
- Operations with body params

## 3. Solution Analysis

### Current Coverage
- Class existence (6 tests)

### Missing Coverage
- Constructor parameter type (handler interface)
- __invoke parameter types
- Petshop controllers

## 4. Implementation Specification

### Test Files
```
tests/Feature/
├── Tictactoe/
│   └── ControllerGenerationTest.php  # Expand existing
└── Petshop/
    └── ControllerGenerationTest.php  # New
```

### Example Tests
```php
public function testControllerInjectsCorrectHandlerType(): void
{
    $constructor = (new ReflectionClass(CreateGameController::class))
        ->getConstructor();
    $handlerParam = $constructor->getParameters()[0];
    $this->assertSame(
        GameManagementHandlerInterface::class,
        $handlerParam->getType()->getName()
    );
}

public function testGetGameControllerHasPathParameter(): void
{
    $invoke = new ReflectionMethod(GetGameController::class, '__invoke');
    $params = $invoke->getParameters();
    $this->assertSame('game_id', $params[1]->getName());
}
```

## 5. Acceptance Criteria

- [ ] Expand TicTacToe controller tests
- [ ] Add Petshop controller tests
- [ ] Test constructor injection types
- [ ] Test __invoke parameter types
- [ ] All tests pass