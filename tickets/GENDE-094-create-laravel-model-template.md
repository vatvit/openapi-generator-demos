---
code: GENDE-094
status: Implemented
dateCreated: 2026-01-07T16:39:56.605Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Laravel model template

## 1. Description

Create the model.mustache template for Laravel DTOs generated from OpenAPI schemas.

## 2. Rationale

Typed DTOs enforce API contract:
- Typed properties from schema
- fromArray/toArray for serialization
- Validation support

## 3. Solution Analysis

### Model Pattern
```php
class Pet
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $tag = null,
    ) {}

    public static function fromArray(array $data): self { ... }
    public function toArray(): array { ... }
}
```

### Template Variables Used
- `classname`
- `vars` (properties)
- `dataType`
- `required`
- `hasValidation`

## 4. Implementation Specification

### Template Location
`src/main/resources/{generator-name}/model.mustache`

## 5. Acceptance Criteria

- [ ] Template generates valid PHP 8.1+ DTOs
- [ ] Readonly properties where appropriate
- [ ] Nullable types for optional fields
- [ ] fromArray/toArray methods
- [ ] Passes PHPStan level 6