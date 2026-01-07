---
code: GENDE-117
status: Proposed
dateCreated: 2026-01-07T16:42:24.051Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 4: Slim
relatedTickets: GENDE-088,GENDE-116
dependsOn: GENDE-116
---

# Create Slim controller (action) template

## 1. Description

Create Slim action template (Slim uses "actions" not "controllers").

## 2. Rationale

Slim 4 patterns:
- Single-action classes (invokable)
- PSR-7 request/response
- PHP-DI for dependency injection

## 3. Solution Analysis

### Slim Action Pattern
```php
class CreatePetAction
{
    public function __construct(
        private PetApiHandlerInterface $handler
    ) {}

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $body = $request->getParsedBody();
        $result = $this->handler->createPet(CreatePetRequest::fromArray($body));
        
        $response->getBody()->write(json_encode($result->toArray()));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(201);
    }
}
```

## 4. Implementation Specification

### Template Differences
| Aspect | Laravel | Slim |
|--------|---------|------|
| Request | FormRequest | PSR-7 ServerRequest |
| Response | JsonResponse | PSR-7 Response |
| DI | Service Provider | PHP-DI |

## 5. Acceptance Criteria

- [ ] PSR-7 compliant
- [ ] __invoke pattern
- [ ] DI injection works
- [ ] PHPStan level 6 passes