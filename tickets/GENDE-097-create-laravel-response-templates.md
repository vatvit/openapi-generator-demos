---
code: GENDE-097
status: Implemented
dateCreated: 2026-01-07T16:39:57.058Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Laravel response templates

## 1. Description

Create templates for Laravel response handling (Resources and Response factories).

## 2. Rationale

Typed responses enforce API contract:
- Correct HTTP status codes
- Correct response structure
- Type safety

## 3. Solution Analysis

### Response Factory Pattern
```php
class CreatePetResponse
{
    public static function created(Pet $pet): JsonResponse
    {
        return response()->json(PetResource::make($pet), 201);
    }

    public static function validationError(array $errors): JsonResponse
    {
        return response()->json(['errors' => $errors], 422);
    }
}
```

### Resource Pattern
```php
class PetResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tag' => $this->tag,
        ];
    }
}
```

## 4. Implementation Specification

### Templates
- `response.mustache` - Response factory per operation
- `resource.mustache` - Laravel Resource per model

## 5. Acceptance Criteria

- [ ] Response factory per operation
- [ ] All response codes from spec covered
- [ ] Resources for response models
- [ ] Passes PHPStan level 6