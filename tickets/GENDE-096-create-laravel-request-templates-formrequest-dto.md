---
code: GENDE-096
status: Proposed
dateCreated: 2026-01-07T16:39:56.904Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Laravel request templates (FormRequest + DTO)

## 1. Description

Create templates for Laravel FormRequest validation and Request DTOs.

## 2. Rationale

- FormRequest: Laravel validation rules from OpenAPI schema
- Request DTO: Typed object for handler method signature

## 3. Solution Analysis

### FormRequest Pattern
```php
class CreatePetFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'tag' => ['nullable', 'string'],
        ];
    }
}
```

### Request DTO Pattern
```php
class CreatePetRequest
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $tag = null,
    ) {}

    public static function fromFormRequest(CreatePetFormRequest $request): self { ... }
}
```

## 4. Implementation Specification

### Templates
- `form-request.mustache` - Laravel FormRequest
- `request-dto.mustache` - Typed request DTO (optional)

## 5. Acceptance Criteria

- [ ] FormRequest with validation rules from schema
- [ ] Required/optional fields mapped correctly
- [ ] String constraints (minLength, maxLength, pattern)
- [ ] Numeric constraints (minimum, maximum)
- [ ] Passes PHPStan level 6