# Program Maximum (Laravel-Focused Solution)

This document defines the **ideal solution** - the maximum set of features and components that the generated library should provide for Laravel Framework.

**Current Focus:** Laravel Framework ONLY

**See also:**
- [GOAL.md](GOAL.md) for main objective and success criteria
- **`generated-examples/laravel-max/`** for reference implementation (etalon) showing all patterns below implemented correctly

---

## 0. Library Integration (Manual Control - RECOMMENDED)

**Why Manual Integration is the Right Approach:**

The generator **cannot make assumptions** about your project structure:
- Where do you organize handlers? (`App\Api\`, `App\Services\`, `Domain\`, etc.)
- What route prefix? (`/api/v1`, `/api/v2`, custom paths)
- What middleware? (`['api']`, `['api', 'auth:sanctum']`, custom middleware)
- What domain? (`api.example.com`, no domain)

**Manual integration gives you FULL CONTROL** over your application architecture.

---

### Route Registration (Manual Inclusion)

**Generated:** `routes.php` file with all API routes

**Developer integrates in `routes/api.php`:**
```php
// Developer chooses prefix, middleware, domain, etc.
Route::group(['prefix' => 'v2', 'middleware' => ['api']], function ($router) {
    require base_path('vendor/your-company/petstore-server/routes.php');
    // OR for local development:
    // require base_path('generated/php-laravel/petstore/routes.php');
});
```

**Benefits:**
- ✅ Full control over route prefix and middleware
- ✅ Can wrap in conditions, environments, feature flags
- ✅ Can combine multiple API libraries
- ✅ Clear and explicit
- ✅ No magic or hidden behavior

---

### Dependency Injection Bindings (Manual Registration)

**Generated:** Interface files in `lib/Api/` (e.g., `AddPetApiInterface.php`)

**Developer binds in `app/Providers/AppServiceProvider.php`:**
```php
public function register(): void
{
    $this->app->bind(
        \PetStoreApiV2\Server\Api\AddPetApiInterface::class,
        \App\Api\PetStore\AddPetHandler::class
    );

    $this->app->bind(
        \PetStoreApiV2\Server\Api\FindPetsApiInterface::class,
        \App\Api\PetStore\FindPetsHandler::class
    );
}
```

**Benefits:**
- ✅ Full control over handler namespace and organization
- ✅ Can use your own architectural patterns
- ✅ Can override specific handlers for testing
- ✅ Developer decides the structure, not the generator
- ✅ Clear and explicit (no magic conventions)

---

## 1. Routes File

**Generated routes file with:**
- ✅ All API endpoints defined in OpenAPI spec
- ✅ Mapped to generated controller methods
- ✅ Correct HTTP methods (GET, POST, PUT, DELETE, PATCH, etc.)
- ✅ Route parameters from path (e.g., `/pets/{petId}`)
- ✅ Route naming (e.g., `api.createPet`, `api.findPets`)
- ✅ Ready to include in developer's routes

**Example of generated `routes.php`:**
```php
// Generated file: routes.php
$router->POST('/v2/pets', [PetStoreApiV2\Server\Http\Controllers\AddPetController::class, 'addPet'])
    ->name('api.addPet');

$router->GET('/v2/pets/{id}', [PetStoreApiV2\Server\Http\Controllers\FindPetByIdController::class, 'findPetById'])
    ->name('api.findPetById');
```

## 2. Middleware Attachment (Conditional via Groups - RECOMMENDED)

**Why This Approach is Program Maximum:**

Given that the **generator cannot know your project's middleware requirements**, this approach provides:
- ✅ **Maximum flexibility** - developer decides which operations need middleware
- ✅ **Per-operation granularity** - each endpoint can have unique middleware
- ✅ **Opt-in by default** - no middleware attached unless explicitly configured
- ✅ **Clear naming convention** - `api.middlewareGroup.{operationId}`
- ✅ **No assumptions** - generator doesn't guess what middleware you need

**This is the ideal solution** because the library/generator knows nothing about:
- What authentication middleware you use (Sanctum, Passport, JWT, custom)
- What authorization logic you need (roles, permissions, ownership)
- What other middleware you want (throttling, caching, logging, etc.)
- Which operations need which middleware

---

**How It Works:**

**Generated route structure:**
```php
// Generated routes.php
$route = $router->POST('/v2/pets', [AddPetController::class, 'addPet'])
    ->name('api.addPet');

// Conditionally attach middleware if group is defined
if ($router->hasMiddlewareGroup('api.middlewareGroup.addPet')) {
    $route->middleware('api.middlewareGroup.addPet');
}
```

**Developer configures middleware in `bootstrap/app.php`:**
```php
->withMiddleware(function (Middleware $middleware): void {
    // Define middleware groups for specific operations
    $middleware->group('api.middlewareGroup.addPet', [
        \App\Http\Middleware\ValidateOwnership::class,
        \App\Http\Middleware\LogCreation::class,
    ]);

    $middleware->group('api.middlewareGroup.deletePet', [
        \App\Http\Middleware\RequireAdmin::class,
    ]);
})
```

---

**Benefits:**
- ✅ Routes have NO middleware by default (only if group is defined)
- ✅ Developer has full control over which operations get middleware
- ✅ Can attach multiple middleware to an operation (array of middleware)
- ✅ Can reuse middleware across operations (define group once, use many times)
- ✅ Can use existing project middleware (no need to create new ones)
- ✅ Clear separation of concerns (routing vs middleware logic)
- ✅ Easy to add/remove middleware without modifying generated code

---

## 3. Security Middleware (Interface + Stub + Validator)

**OpenAPI Security Context:**

OpenAPI `security` attribute defines:
- ✅ **WHAT** security is needed (bearerAuth, apiKey, oauth2, etc.)
- ✅ **WHERE** credentials are sent (header, query, cookie)
- ✅ **FORMAT** (Bearer token, API key name, OAuth flows)

OpenAPI **DOES NOT** define:
- ❌ **HOW** to validate tokens (implementation logic)
- ❌ **WHICH** library/framework to use (Sanctum, Passport, JWT, custom)

**Because the generator cannot know your authentication implementation, it must:**
1. Generate structure (interfaces, stubs)
2. Guarantee middleware attachment to endpoints
3. Validate configuration (catch missing middleware)
4. Leave implementation to developer

**⚠️ Documentation-only approach is NOT acceptable** - it provides no enforcement and developers can easily forget to implement security.

---

### Required Approach (Interface + Stub + Validator)

**Generated Components (per security scheme):**

**1. Security Middleware Interface** (Contract)

```php
// lib/Security/BearerHttpAuthenticationInterface.php
namespace ApiV2\Server\Security;

use Illuminate\Http\Request;
use Closure;

/**
 * Interface for bearerHttpAuthentication security middleware
 *
 * OpenAPI Security Scheme: bearerHttpAuthentication
 * Type: http (bearer)
 * Format: JWT
 *
 * Implement this interface in your authentication middleware.
 * The SecurityValidator will verify middleware implements this interface.
 */
interface BearerHttpAuthenticationInterface
{
    public function handle(Request $request, Closure $next);
}
```

**2. Security Middleware Stub** (Empty implementation with guidance)

```php
// lib/Security/Middleware/BearerHttpAuthenticationMiddleware.php
namespace ApiV2\Server\Security\Middleware;

use Illuminate\Http\Request;
use Closure;
use ApiV2\Server\Security\BearerHttpAuthenticationInterface;

/**
 * Bearer HTTP Authentication Middleware (STUB)
 *
 * TODO: Implement your authentication logic
 *
 * Choose your implementation:
 * - Laravel Sanctum, Passport, JWT library, or custom
 * - OR replace with existing middleware (must implement interface)
 */
class BearerHttpAuthenticationMiddleware implements BearerHttpAuthenticationInterface
{
    public function handle(Request $request, Closure $next)
    {
        // TODO: Implement bearer token authentication
        throw new \RuntimeException(
            'BearerHttpAuthenticationMiddleware not implemented. ' .
            'Please implement authentication logic in ' . __CLASS__
        );
    }
}
```

**3. SecurityValidator** (Development-time validation)

```php
// lib/Security/SecurityValidator.php
namespace ApiV2\Server\Security;

use Illuminate\Routing\Router;

/**
 * Validates that required security middleware is properly configured
 *
 * Runs ONLY in debug mode (APP_DEBUG=true).
 * Throws RuntimeException if middleware is missing or incorrect.
 */
class SecurityValidator
{
    private static array $securityRequirements = [
        'createGame' => [BearerHttpAuthenticationInterface::class],
        'deleteGame' => [BearerHttpAuthenticationInterface::class],
        // ... other operations
    ];

    public static function validateMiddleware(Router $router): void
    {
        // Validates middleware is configured correctly
        // Checks: group exists, implements required interface
        // Throws exception if missing/incorrect
    }
}
```

**4. Routes file** (with validator call)

```php
/**
 * POST /games
 * Security Requirements:
 * - bearerHttpAuthentication (http): Bearer token using a JWT
 *
 * Suggested middleware group (in bootstrap/app.php):
 * $middleware->group('api.middlewareGroup.createGame', [
 *     \ApiV2\Server\Security\Middleware\BearerHttpAuthenticationMiddleware::class,
 * ]);
 */
$route = $router->POST('/v1/games', [CreateGameController::class, 'createGame'])
    ->name('api.createGame');

// SECURITY REQUIREMENT: This operation requires authentication
// Middleware group MUST contain middleware implementing:
// - ApiV2\Server\Security\BearerHttpAuthenticationInterface
if ($router->hasMiddlewareGroup('api.middlewareGroup.createGame')) {
    $route->middleware('api.middlewareGroup.createGame');
}

// ... other routes ...

// Security validation (runs only in debug mode)
if (config('app.debug', false)) {
    if (class_exists(ApiV2\Server\Security\SecurityValidator::class)) {
        try {
            ApiV2\Server\Security\SecurityValidator::validateMiddleware($router);
        } catch (\RuntimeException $e) {
            error_log("Security middleware validation failed:");
            error_log($e->getMessage());
        }
    }
}
```

---

### Developer Workflow

**Use Generated Stub (modify it):**
```php
// 1. Modify lib/Security/Middleware/BearerHttpAuthenticationMiddleware.php
//    Implement your authentication logic

// 2. Register in bootstrap/app.php
$middleware->group('api.middlewareGroup.createGame', [
    ApiV2\Server\Security\Middleware\BearerHttpAuthenticationMiddleware::class,
]);
```

---

### Why Program Maximum is Better

**Interface provides:**
- ✅ Contract enforcement - middleware must implement interface
- ✅ Validation compatibility - SecurityValidator can check interface
- ✅ Type safety - ensures handle() method signature
- ✅ Documentation - interface documents what's required

**Stub provides:**
- ✅ Starting point - developer doesn't start from scratch
- ✅ Guidance - TODO comments explain steps
- ✅ Optional - can be ignored if developer has existing middleware

**Validator provides:**
- ✅ Development-time checks - catches missing/incorrect configuration
- ✅ Cannot forget security - throws exception if middleware missing
- ✅ Interface validation - ensures middleware compatibility
- ✅ Debug-only - no performance impact in production

**Flexibility maintained:**
- Developer chooses implementation (Sanctum, Passport, JWT, custom)
- Can use generated stub OR existing middleware
- Can ignore stubs completely (must implement interface)
- No assumptions about authentication system

---

## 4. Laravel Validators

**Request validation using Laravel's built-in validation:**
- ✅ Auto-generate validation rules from OpenAPI schema
- ✅ Use Laravel FormRequest classes OR inline validation
- ✅ Type constraints (string, integer, boolean, array, object)
- ✅ Value constraints (min, max, minLength, maxLength, pattern)
- ✅ Required vs optional fields
- ✅ Enum validation
- ✅ Custom error messages

**Example:**
```php
// Auto-generated FormRequest
class CreatePetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'age' => 'nullable|integer|min:0|max:30',
            'type' => 'required|string|in:dog,cat,bird',
        ];
    }
}
```

## 5. Custom Request OR DTO (Operation Input)

**Request handling options:**

**Option A: Custom FormRequest classes** (Laravel standard)
- ✅ Extends `Illuminate\Foundation\Http\FormRequest`
- ✅ Built-in validation rules
- ✅ Authorization logic
- ✅ Typed accessor methods

**Option B: Request DTOs** (Type-safe alternative)
- ✅ Plain PHP classes with typed properties
- ✅ Constructor for initialization
- ✅ Validation via separate validator

**Generated library should provide ONE consistent approach** (prefer FormRequest for Laravel)

**Example (FormRequest approach):**
```php
class CreatePetRequest extends FormRequest
{
    public function rules(): array { /* ... */ }

    public function getName(): string
    {
        return $this->validated('name');
    }

    public function getAge(): ?int
    {
        return $this->validated('age');
    }
}
```

## 6. Contract Enforcement (Request/Response Flow)

**Force developer to respect API contract:**

**Input Contract:**
- ✅ Controller method receives typed Request/DTO
- ✅ Developer cannot access non-existent properties
- ✅ Validation enforced before reaching business logic

**Output Contract:**
- ✅ Controller/Handler must return Laravel Resource OR Response object
- ✅ Response structure must match OpenAPI response schema
- ✅ Response factory/builder enforces schema compliance
- ✅ HTTP status codes from OpenAPI spec

**Example:**
```php
// Interface contract
interface CreatePetApiInterface
{
    public function createPet(CreatePetRequest $request): JsonResponse|PetResource;
}

// Developer implementation
class CreatePetHandler implements CreatePetApiInterface
{
    public function createPet(CreatePetRequest $request): PetResource
    {
        // Input: Type-safe request
        $pet = Pet::create([
            'name' => $request->getName(),
            'age' => $request->getAge(),
        ]);

        // Output: Must return PetResource (enforced by interface)
        return new PetResource($pet);
    }
}
```

## 7. Responses/Resources According to Spec

**Laravel Resources for response transformation:**
- ✅ Auto-generate `JsonResource` classes for each response schema
- ✅ Transform data to match OpenAPI response structure
- ✅ Support for nested resources
- ✅ Support for resource collections
- ✅ Correct HTTP status codes for each response type

**Response factories for multiple response types:**
- ✅ Factory methods for different status codes (200, 201, 400, 404, etc.)
- ✅ Type-safe response builders
- ✅ Enforce response schema for each status code

**Example:**
```php
// Auto-generated Resource
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

// Auto-generated Response Factory
class CreatePetResponseFactory
{
    public static function created(Pet $pet): JsonResponse
    {
        return (new PetResource($pet))
            ->response()
            ->setStatusCode(201);
    }

    public static function validationError(array $errors): JsonResponse
    {
        return response()->json(['errors' => $errors], 400);
    }
}
```

## 8. Data Organization (DTOs or Models)

**Data structures for request/response bodies:**

**Option A: Eloquent Models** (if API represents database entities)
- Use existing Laravel Eloquent models
- Resources transform models to API response format

**Option B: Data Transfer Objects (DTOs)** (if API is model-agnostic)
- ✅ Plain PHP classes with typed properties
- ✅ Represent OpenAPI schemas exactly
- ✅ Independent of database structure
- ✅ Used for complex nested objects

**Generated library should support both approaches:**
- Developer can use Eloquent models and transform via Resources
- OR use generated DTOs for type-safe data structures

**Example (DTO approach):**
```php
// Auto-generated DTO from OpenAPI schema
class Pet
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $tag = null,
    ) {}
}
```

## 9. Controller Organization

**Requirement:** Controllers should be organized logically, either as:
- **One controller for all operations**, OR
- **Multiple controllers grouped logically**

The generated library should provide a **consistent, logical grouping strategy**.

---

**Recommended: Separate Controllers per Operation** (Command pattern)

**Benefits:**
- ✅ **Single Responsibility Principle** - one class, one operation
- ✅ Clear separation of concerns
- ✅ Easy to locate specific operation logic
- ✅ No bloated controller classes
- ✅ Ideal for complex operations with unique logic
- ✅ Easy to test individual operations

**Example:**
```php
// AddPetController.php - Handles ONLY pet creation
class AddPetController extends Controller
{
    public function addPet(AddPetApiInterface $handler, Request $request): JsonResponse
    {
        // Focused on single operation
    }
}

// DeletePetController.php - Handles ONLY pet deletion
class DeletePetController extends Controller
{
    public function deletePet(DeletePetApiInterface $handler, int $id): JsonResponse
    {
        // Focused on single operation
    }
}
```

**Alternative: Controllers Grouped by Tag/Resource** (also valid)
- Operations grouped by OpenAPI tags or resource type
- Example: `PetController`, `UserController`
- Fewer files, related operations together
- Trade-off: Controllers can become large

**Both approaches are valid.** The key requirement is **logical organization**.

---

## Summary: Complete Generated Library Components

The **ideal Laravel-focused library** provides:

0. ✅ **Library Integration** - Manual control over routes and DI bindings (RECOMMENDED)
1. ✅ **Routes File** - Ready-to-include routes with proper naming and structure
2. ✅ **Controllers** - Organized by operation/tag (configurable)
3. ✅ **Middleware Support** - Conditional attachment via middleware groups
4. ✅ **Security Middleware** - Interface + Stub + Validator (REQUIRED)
   - Generate interface for each security scheme
   - Generate stub with TODO comments
   - Generate validator to enforce configuration
5. ✅ **Laravel Validators** - Auto-generated validation rules (FormRequest OR inline)
6. ✅ **API Interfaces** - Contracts for business logic handlers
7. ✅ **Response Classes/Resources** - Type-safe response handling per OpenAPI schema
8. ✅ **Response Factories** - Type-safe response builders with status codes
9. ✅ **DTOs/Models** - Data structures from OpenAPI schemas
10. ✅ **Clear Documentation** - Integration examples and usage guidelines

**Developer workflow:**
1. Install library via Composer: `composer require vendor/api-library`
2. Include routes in `routes/api.php` with desired prefix/middleware
3. Bind API interfaces to handlers in `AppServiceProvider` (or separate provider)
4. Implement business logic handlers (no generated code modification)
5. (Optional) Configure middleware groups for operations requiring custom middleware
6. (Optional) Create security middleware for operations with authentication requirements
7. Done - Type safety and validation enforce the API contract automatically
