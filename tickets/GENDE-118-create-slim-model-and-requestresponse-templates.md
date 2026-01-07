---
code: GENDE-118
status: Proposed
dateCreated: 2026-01-07T16:42:24.211Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 4: Slim
relatedTickets: GENDE-088,GENDE-117
dependsOn: GENDE-117
---

# Create Slim model and request/response templates

## 1. Description

Create Slim templates for models and request/response handling.

## 2. Rationale

Slim uses:
- Same DTO pattern (portable)
- Manual validation (or Respect/Validation)
- PSR-7 response building

## 3. Solution Analysis

### Model (same as Laravel/Symfony)
```php
class Pet
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {}
}
```

### Request DTO
```php
class CreatePetRequest
{
    public function __construct(
        public readonly string $name,
    ) {}

    public static function fromArray(array $data): self { ... }
    
    public function validate(): array { ... } // Returns errors
}
```

## 4. Implementation Specification

### Templates
- `model.mustache` - DTO (can reuse)
- `request.mustache` - With validation method
- `response.mustache` - PSR-7 response helper

## 5. Acceptance Criteria

- [ ] Models generate correctly
- [ ] Request validation works
- [ ] Response building works
- [ ] PHPStan level 6 passes