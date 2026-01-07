---
code: GENDE-093
status: Proposed
dateCreated: 2026-01-07T16:39:56.464Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Laravel controller template (per-operation)

## 1. Description

Create the controller.mustache template for Laravel that generates one controller per operation.

## 2. Rationale

Per-operation controllers provide:
- Single responsibility
- Clean __invoke pattern
- Easy testing
- Clear routing

## 3. Solution Analysis

### Controller Pattern
```php
class CreatePetController extends Controller
{
    public function __construct(
        private PetApiHandlerInterface $handler
    ) {}

    public function __invoke(CreatePetRequest $request): JsonResponse
    {
        return $this->handler->createPet($request);
    }
}
```

### Template Variables Used
- `operationIdPascalCase`
- `operationId`
- `httpMethod`
- `hasBodyParam`
- `hasPathParams`
- `hasQueryParams`

## 4. Implementation Specification

### Template Location
`src/main/resources/{generator-name}/controller.mustache`

## 5. Acceptance Criteria

- [ ] Template generates valid PHP
- [ ] One controller per operation
- [ ] Uses __invoke pattern
- [ ] Injects handler interface
- [ ] Passes PHPStan level 6