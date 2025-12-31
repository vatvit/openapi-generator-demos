# Generator Comparison: laravel-max vs php-laravel

**Last Updated:** 2025-12-31
**Related Ticket:** GENDE-004

---

## Executive Summary

This document compares two approaches for generating Laravel API libraries from OpenAPI specifications:

| Generator | Type | Status |
|-----------|------|--------|
| **laravel-max** | Custom Java generator | Production-ready |
| **php-laravel** | Built-in generator + custom templates | Production-ready |

**Key Finding:** Both generators achieve similar file structures with custom templates, but **laravel-max provides stricter type safety** through union return types and security validation.

---

## Feature Matrix (GOAL_MAX.md Compliance)

### Legend
- ✅ Fully implemented
- ⚠️ Partially implemented / different approach
- ❌ Not implemented

| Feature | laravel-max | php-laravel | Notes |
|---------|:-----------:|:-----------:|-------|
| **Routes** | | | |
| Auto-generated routes | ✅ | ✅ | Both generate routes.php |
| Route naming | ✅ | ✅ | `api.{operationId}` |
| Conditional middleware | ✅ | ❌ | laravel-max uses `hasMiddlewareGroup()` |
| **Controllers** | | | |
| One controller per operation | ✅ | ✅ | Both achieve this with custom templates |
| Invokable controllers (`__invoke`) | ✅ | ❌ | php-laravel uses named methods |
| Constructor injection | ✅ | ⚠️ | php-laravel uses method injection |
| `final` keyword | ✅ | ❌ | laravel-max prevents extension |
| **Request Handling** | | | |
| FormRequest generation | ✅ | ❌ | php-laravel uses inline validation |
| Query parameter DTOs | ✅ | ❌ | laravel-max generates `*QueryParams.php` |
| Body DTOs | ✅ | ✅ | Both generate from schemas |
| **Response Handling** | | | |
| One Resource per response code | ✅ | ⚠️ | php-laravel uses ResponseFactory |
| Laravel Resources (`JsonResource`) | ✅ | ❌ | php-laravel uses custom Response classes |
| HTTP status code enforcement | ✅ | ✅ | Different approaches |
| Required headers handling | ⚠️ | ✅ | php-laravel has header setters |
| **Type Safety** | | | |
| Union return types | ✅ | ❌ | laravel-max: `201Resource\|400Resource` |
| Typed DTO properties | ✅ | ✅ | Both use PHP 8.1+ types |
| Enum support | ✅ | ✅ | Both generate PHP 8.1 enums |
| **Security** | | | |
| Security interface per scheme | ✅ | ❌ | laravel-max only |
| SecurityValidator | ✅ | ❌ | Debug-time validation |
| Security middleware stubs | ❌ | ❌ | Neither generates stubs |
| **Handler Interfaces** | | | |
| Interface per operation | ❌ | ✅ | php-laravel has one per operation |
| Interface per tag (grouped) | ✅ | ❌ | laravel-max groups by tag |
| Type-safe method signatures | ✅ | ✅ | Both enforce contracts |

---

## Detailed Comparison

### 1. Controller Pattern

**laravel-max:**
```php
final class CreateGameController
{
    public function __construct(
        private readonly GameManagementApiHandlerInterface $handler
    ) {}

    public function __invoke(CreateGameFormRequest $request): JsonResponse
    {
        $dto = CreateGameRequest::fromArray($request->validated());
        $resource = $this->handler->createGame($dto);
        return $resource->response($request);
    }
}
```

**php-laravel:**
```php
class CreateGameController extends Controller
{
    public function createGame(
        CreateGameApiInterface $handler,
        Request $request
    ): JsonResponse
    {
        $validated = $request->validate($this->createGameValidationRules());
        $serde = new SerdeCommon();
        $createGameRequest = $serde->deserialize($request->getContent(), ...);
        $response = $handler->handle($createGameRequest);
        return $response->toJsonResponse();
    }
}
```

**Analysis:**
| Aspect | laravel-max | php-laravel |
|--------|-------------|-------------|
| Injection | Constructor (readonly) | Method parameter |
| Method | `__invoke` (invokable) | Named method |
| Validation | FormRequest (Laravel) | Inline rules |
| Immutability | `final` class | Extensible |

### 2. Handler Interface Pattern

**laravel-max** (grouped by tag):
```php
interface GameManagementApiHandlerInterface
{
    public function createGame(CreateGameRequest $dto):
        CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource;

    public function deleteGame(string $gameId):
        DeleteGame204Resource|DeleteGame403Resource|DeleteGame404Resource;

    public function getGame(string $gameId):
        GetGame200Resource|GetGame404Resource;
}
```

**php-laravel** (one per operation):
```php
interface CreateGameApiInterface
{
    public function handle(CreateGameRequest $request):
        CreateGameApiInterfaceResponseInterface;
}
```

**Analysis:**
| Aspect | laravel-max | php-laravel |
|--------|-------------|-------------|
| Grouping | By OpenAPI tag | One per operation |
| Return type | Union types (specific) | Interface (generic) |
| Type safety | Compile-time | Runtime |
| Binding effort | Fewer bindings | More bindings |

### 3. Response Pattern

**laravel-max** (Laravel Resources):
```php
final class CreateGame201Resource extends JsonResource
{
    protected int $httpCode = 201;

    public function toArray($request): array
    {
        $model = $this->resource;
        return [
            'id' => $model->id,
            'status' => $model->status,
            // ...
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);
    }
}
```

**php-laravel** (ResponseFactory):
```php
final class CreateGameApiInterfaceResponseFactory
{
    public static function status201(Game $data, ?string $location = null):
        CreateGameApiInterfaceResponseInterface
    {
        $response = new CreateGameApiInterfaceResponse(201, $data);
        if ($location !== null) {
            $response->setLocation($location);
        }
        return $response;
    }

    public static function status400(BadRequestError $data):
        CreateGameApiInterfaceResponseInterface { ... }
}
```

**Analysis:**
| Aspect | laravel-max | php-laravel |
|--------|-------------|-------------|
| Pattern | Laravel Resource | Custom ResponseFactory |
| Laravel alignment | Native | Custom |
| Header handling | Via `withResponse()` | Explicit setters |
| Type enforcement | Separate classes | Factory methods |

### 4. Security Handling

**laravel-max** generates:
- `BearerHttpAuthenticationInterface.php`
- `DefaultApiKeyInterface.php`
- `App2AppOauthInterface.php`
- `SecurityValidator.php`

**php-laravel** generates:
- ❌ No security interfaces
- ❌ No validator

**laravel-max SecurityValidator:**
```php
// Routes file includes:
if (config('app.debug', false)) {
    \TictactoeApi\Api\Security\SecurityValidator::validateMiddleware($router);
}
```

### 5. Generated File Counts (TicTacToe spec)

| Directory | laravel-max | php-laravel |
|-----------|-------------|-------------|
| Controllers | 10 | 10 |
| Resources | 37 | 0 |
| Responses | 0 | 30 |
| FormRequests | 2 | 0 |
| Models/DTOs | 22 | 49 |
| Handlers | 4 | 10 |
| Security | 6 | 0 |
| QueryParams | 2 | 0 |
| **Total PHP files** | 82 | 89 |

---

## Key Differences Summary

| Aspect | laravel-max | php-laravel |
|--------|-------------|-------------|
| **Architecture** | Laravel-native patterns | Generic PHP patterns |
| **Type Safety** | Union return types | Interface return types |
| **Validation** | FormRequest classes | Inline validation rules |
| **Responses** | Laravel Resources | Custom Response classes |
| **Security** | Interfaces + Validator | None |
| **Handler grouping** | By OpenAPI tag | One per operation |
| **Immutability** | `final` classes | Extensible classes |
| **DI pattern** | Constructor injection | Method injection |

---

## Recommendations

### Use laravel-max when:
- ✅ Building Laravel applications (native patterns)
- ✅ Need compile-time type safety (union types)
- ✅ Need security validation (SecurityValidator)
- ✅ Prefer FormRequest validation
- ✅ Want immutable generated code (`final`)

### Use php-laravel when:
- ✅ Need community-maintained generator
- ✅ Want one handler interface per operation
- ✅ Prefer method injection pattern
- ✅ Need explicit header handling in responses
- ✅ Building framework-agnostic PHP

---

## Conclusion

Both generators produce **high-quality, contract-enforced API code**. The choice depends on:

1. **Laravel alignment**: laravel-max uses native Laravel patterns (Resources, FormRequests)
2. **Type safety**: laravel-max provides stricter compile-time type checking via union types
3. **Security**: Only laravel-max generates security interfaces and validation
4. **Maintainability**: php-laravel is community-maintained; laravel-max is custom

**Recommendation:** For Laravel projects requiring strict contract enforcement and security validation, **laravel-max is the preferred choice**. For projects needing community support or framework flexibility, php-laravel with custom templates is viable.
