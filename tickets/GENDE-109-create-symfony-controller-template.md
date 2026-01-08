---
code: GENDE-109
status: Implemented
dateCreated: 2026-01-07T16:41:33.620Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 3: Symfony
relatedTickets: GENDE-088,GENDE-108
dependsOn: GENDE-108
---

# Create Symfony controller template

## 1. Description

Create Symfony controller template adapted from Laravel pattern.

## 2. Rationale

Symfony controllers differ from Laravel:
- Use attributes for routing
- Different DI approach
- Different request/response handling

## 3. Solution Analysis

### Symfony Controller Pattern
```php
#[Route('/pets', methods: ['POST'])]
class CreatePetController extends AbstractController
{
    public function __construct(
        private PetApiHandlerInterface $handler
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $dto = CreatePetRequest::fromRequest($request);
        return $this->handler->createPet($dto)->toJsonResponse();
    }
}
```

## 4. Implementation Specification

### Template Differences from Laravel
| Aspect | Laravel | Symfony |
|--------|---------|----------|
| Routing | routes.php | Attributes |
| Request | FormRequest | Manual validation |
| Response | response()->json() | JsonResponse |
| DI | Service Provider | services.yaml |

## 5. Acceptance Criteria

- [ ] Symfony-compatible controller
- [ ] Route attributes correct
- [ ] DI injection works
- [ ] PHPStan level 6 passes