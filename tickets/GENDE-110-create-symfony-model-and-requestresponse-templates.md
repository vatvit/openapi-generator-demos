---
code: GENDE-110
status: Proposed
dateCreated: 2026-01-07T16:41:33.777Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 3: Symfony
relatedTickets: GENDE-088,GENDE-109
dependsOn: GENDE-109
---

# Create Symfony model and request/response templates

## 1. Description

Create Symfony templates for models, requests, and responses.

## 2. Rationale

Symfony uses:
- Same DTO pattern as Laravel (portable)
- Symfony Validator for validation
- Custom request/response handling

## 3. Solution Analysis

### Model (same as Laravel)
```php
class Pet
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {}
}
```

### Request with Validator
```php
class CreatePetRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $name;

    public static function fromRequest(Request $request): self { ... }
}
```

## 4. Implementation Specification

### Templates
- `model.mustache` - DTO (can reuse Laravel)
- `request.mustache` - With Symfony Validator attributes
- `response.mustache` - Symfony JsonResponse

## 5. Acceptance Criteria

- [ ] Models generate correctly
- [ ] Validation attributes from schema
- [ ] Response factories work
- [ ] PHPStan level 6 passes