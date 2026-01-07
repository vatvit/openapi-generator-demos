---
code: GENDE-093
status: Implemented
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
- [x] Template generates valid PHP
- [x] One controller per operation
- [x] Uses __invoke pattern
- [x] Injects handler interface
- [ ] Passes PHPStan level 6 (requires integration project for verification)

### Implementation Notes

**Template Features:**
- `declare(strict_types=1)` for strict typing
- `final` class declaration
- Constructor property promotion with `readonly`
- `__invoke` pattern for single-action controller
- PHPDoc comments with operation summary/notes
- Proper namespace aliasing for body DTOs (avoids naming conflicts)

**Parameter Handling:**
- Path params: Injected as typed method arguments
- Query params: Extracted with type casting and null handling
- Body params: Converted to DTO with `fromArray()`

**Handler Delegation:**
- Argument order: path params → query params → body DTO
- Returns response via `$response->toJsonResponse()`

**Known Issue Resolved:**
- Model DTO aliased as `{BaseType}Dto` to avoid conflict with FormRequest class name