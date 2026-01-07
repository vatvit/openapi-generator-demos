---
code: GENDE-095
status: Implemented
dateCreated: 2026-01-07T16:39:56.754Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 2: Laravel
relatedTickets: GENDE-088,GENDE-092
dependsOn: GENDE-092
---

# Create Laravel handler interface template (per-tag)

## 1. Description

Create the api-interface.mustache template that generates handler interfaces per API tag.

## 2. Rationale

Handler interfaces:
- Define contract for business logic
- Enable dependency injection
- Separate HTTP layer from business logic

## 3. Solution Analysis

### Interface Pattern
```php
interface PetApiHandlerInterface
{
    public function createPet(CreatePetRequest $request): CreatePetResponse;
    public function findPets(FindPetsRequest $request): FindPetsResponse;
    public function getPetById(int $id): GetPetByIdResponse;
}
```

### Template Variables Used
- `classname` (tag name)
- `operations` (list of operations)
- `operationId`
- `returnType`

## 4. Implementation Specification

### Template Location
`src/main/resources/{generator-name}/api-interface.mustache`

## 5. Acceptance Criteria

- [ ] One interface per API tag
- [ ] All operations for tag included
- [ ] Typed parameters and return types
- [ ] Passes PHPStan level 6