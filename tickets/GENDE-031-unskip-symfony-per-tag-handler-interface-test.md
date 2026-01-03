---
code: GENDE-031
status: Blocked
dateCreated: 2026-01-03T12:00:00.000Z
type: Test
priority: Low
relatedTickets: GENDE-030
blockedBy: GENDE-030
---

# Unskip Symfony per-TAG handler interface test

## 1. Description

The Symfony integration test `test_all_per_tag_handler_interfaces_exist` is currently skipped due to a generator bug (GENDE-030). Once the bug is fixed, this test should be unskipped.

**Current state:**
```php
public function test_all_per_tag_handler_interfaces_exist(): void
{
    $this->markTestSkipped('Per-TAG handler interfaces have naming bug (class name != filename)');
}
```

**Desired state:**
Test runs and validates that all per-TAG handler interfaces exist and are properly named.

## 2. Blocked By

- **GENDE-030**: Fix Symfony per-TAG handler interface class/filename mismatch

## 3. Implementation

After GENDE-030 is fixed:

1. Regenerate Symfony code with fixed templates
2. Update the test file to restore the original test logic:

```php
public function test_all_per_tag_handler_interfaces_exist(): void
{
    $interfaces = [
        GameManagementApiHandlerInterface::class,
        GameplayApiHandlerInterface::class,
        StatisticsApiHandlerInterface::class,
        TicTacApiHandlerInterface::class,
    ];

    foreach ($interfaces as $interface) {
        $this->assertTrue(
            interface_exists($interface),
            "Interface should exist: $interface"
        );
    }
}
```

3. Uncomment the use statements:
```php
use TictactoeApi\Api\Handler\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Handler\GameplayApiHandlerInterface;
use TictactoeApi\Api\Handler\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Handler\TicTacApiHandlerInterface;
```

4. Run tests to verify

## 4. Artifact Locations

- **Test file**: `projects/symfony-api--symfony-max--integration-tests/tests/Feature/Tictactoe/ServiceInterfaceTest.php`

## 5. Acceptance Criteria

- [ ] GENDE-030 is completed (generator bug fixed)
- [ ] Test is unskipped and runs successfully
- [ ] All 4 per-TAG handler interfaces pass the existence check
- [ ] No skipped tests in Symfony integration test suite
