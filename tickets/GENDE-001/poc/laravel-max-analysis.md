# Laravel-Max Reference Implementation - Complete Analysis

## Executive Summary

The `laravel-max/` reference implementation demonstrates **exceptional architecture** for generating type-safe, contract-enforced Laravel API libraries from OpenAPI specifications.

**Core Innovation:** One Resource per operation+response (not per schema), with hardcoded HTTP codes and runtime header validation.

---

## File Structure Analysis

```
laravel-max/
├── routes/
│   └── api.php                           # Routes with conditional middleware
├── Http/
│   ├── Middleware/
│   │   ├── AuthenticateGame.php         # Security middleware (implements interface)
│   │   └── AuthenticateApiToken.php
│   ├── Requests/
│   │   ├── CreateGameRequest.php        # FormRequest validation
│   │   ├── ListGamesRequest.php
│   │   └── MoveRequest.php
│   ├── Controllers/
│   │   ├── CreateGameController.php     # Invokable controller (one per operation)
│   │   ├── GetGameController.php
│   │   ├── ListGamesController.php
│   │   ├── DeleteGameController.php
│   │   ├── GetBoardController.php
│   │   └── PutSquareController.php
│   └── Resources/
│       ├── CreateGame201Resource.php     # Per operation+code
│       ├── GetGame200Resource.php        # Same schema, different Resource
│       ├── ListGames200Resource.php
│       ├── DeleteGame204Resource.php
│       ├── GetBoard200Resource.php
│       ├── PutSquare200Resource.php
│       ├── ValidationErrorResource.php   # Error responses (422)
│       ├── UnauthorizedErrorResource.php # (401)
│       ├── ForbiddenErrorResource.php    # (403)
│       ├── NotFoundErrorResource.php     # (404)
│       ├── ConflictErrorResource.php     # (409)
│       └── GameCollectionResource.php    # Collection wrapper
├── Models/
│   ├── Game.php                         # Model DTO (from schema)
│   ├── Board.php
│   ├── CreateGameRequestDto.php         # Request DTOs
│   ├── MoveRequestDto.php
│   └── GameListQueryParams.php          # Query params DTO
├── Security/
│   ├── BearerHttpAuthenticationInterface.php # From security scheme
│   └── SecurityValidator.php             # Validates middleware implements interfaces
└── Api/
    └── GameApi.php                       # Handler interface (developer implements)
```

---

## Template Mapping

### Templates Needed (9 Total)

| Template | File Pattern | Generates Per |
|----------|--------------|---------------|
| **route.mustache** | `routes/api.php` | **Once** (all routes) |
| **controller.mustache** | `Http/Controllers/{OperationId}Controller.php` | **Operation** |
| **resource.mustache** | `Http/Resources/{OperationId}{Code}Resource.php` | **Operation+Response** |
| **error-resource.mustache** | `Http/Resources/{ErrorName}Resource.php` | **Error type** |
| **form-request.mustache** | `Http/Requests/{OperationId}Request.php` | **Operation with body** |
| **request-dto.mustache** | `Models/{SchemaName}RequestDto.php` | **Request schema** |
| **model-dto.mustache** | `Models/{SchemaName}.php` | **Component schema** |
| **api-interface.mustache** | `Api/{Tag}Api.php` | **Tag/Group** |
| **security-interface.mustache** | `Security/{SchemeName}Interface.php` | **Security scheme** |

---

## Detailed Component Analysis

### 1. Routes (`routes/api.php`)

**Pattern:** Single file with all routes, conditional middleware attachment

**Key Features:**
```php
// Store route for middleware attachment
$route = $router->POST('/games', CreateGameController::class)
    ->name('api.createGame');

// Conditional middleware (only if group defined)
if ($router->hasMiddlewareGroup('api.middlewareGroup.createGame')) {
    $route->middleware('api.middlewareGroup.createGame');
}
```

**Template Variables Needed:**
- `{{httpMethod}}` - POST, GET, DELETE, etc.
- `{{path}}` - /games, /games/{gameId}, etc.
- `{{operationId}}` - createGame, getGame, etc.
- `{{controllerClass}}` - CreateGameController::class
- `{{#hasAuth}}` - boolean, has security requirements
- `{{securitySchemes}}` - list of schemes for this operation

**Generation:** Loop all operations, one route per operation

---

### 2. Controllers (`Http/Controllers/{OperationId}Controller.php`)

**Pattern:** One invokable controller per operation

**Structure:**
```php
class CreateGameController
{
    public function __construct(
        private readonly GameApi $handler
    ) {}

    public function __invoke(CreateGameRequest $request): JsonResponse
    {
        $dto = CreateGameRequestDto::fromArray($request->validated());
        $resource = $this->handler->createGame($dto);
        return $resource->response($request);
    }
}
```

**Template Variables Needed:**
- `{{operationId}}` - createGame (class: CreateGameController)
- `{{operationIdCamelCase}}` - createGame (method)
- `{{apiInterfaceName}}` - GameApi
- `{{requestClassName}}` - CreateGameRequest (if has body)
- `{{requestDtoClassName}}` - CreateGameRequestDto (if has body)
- `{{#hasRequestBody}}` - boolean
- `{{#pathParams}}` - list of path parameters
- `{{#queryParams}}` - list of query parameters

**Generation:** One file per operation

---

### 3. Resources (`Http/Resources/{OperationId}{Code}Resource.php`)

**Pattern:** One Resource per operation+response code

**CRITICAL:** Same schema gets different Resources for different operations!

**Example 1:** `CreateGame201Resource.php`
```php
class CreateGame201Resource extends JsonResource
{
    protected int $httpCode = 201; // Hardcoded

    public ?string $location = null; // Required header

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'status' => $this->resource->status,
            // ... Game schema properties
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);

        // REQUIRED header validation
        if ($this->location === null) {
            throw new \RuntimeException('Location header REQUIRED');
        }
        $response->header('Location', $this->location);
    }
}
```

**Example 2:** `GetGame200Resource.php` (SAME schema, different Resource)
```php
class GetGame200Resource extends JsonResource
{
    protected int $httpCode = 200; // Different code

    // No location header needed

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'status' => $this->resource->status,
            // ... SAME Game schema properties
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);
        // No headers for GET
    }
}
```

**Template Variables Needed:**
- `{{operationId}}` - createGame
- `{{code}}` - 201, 200, 404, etc.
- `{{schemaName}}` - Game
- `{{schema.properties}}` - list of properties
- `{{#headers}}` - response headers for this code
- `{{header.name}}` - Location, X-Total-Count, etc.
- `{{header.required}}` - boolean
- `{{baseClass}}` - JsonResource or ResourceCollection

**Generation:** One file per operation+response combination

**Key Insight:** `createGame/201` and `getGame/200` both use `Game` schema but get **separate Resource classes** with different HTTP codes and headers!

---

### 4. Error Resources (`Http/Resources/{ErrorName}Resource.php`)

**Pattern:** Reusable error Resources (422, 401, 404, etc.)

**Structure:**
```php
class ValidationErrorResource extends JsonResource
{
    protected int $httpCode = 422; // Hardcoded

    public function toArray($request): array
    {
        return [
            'error' => 'Validation Error',
            'message' => $this->resource['message'] ?? 'Invalid data',
            'errors' => $this->resource['errors'] ?? [],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->httpCode);
    }
}
```

**Template Variables Needed:**
- `{{errorName}}` - ValidationError, Unauthorized, NotFound, etc.
- `{{httpCode}}` - 422, 401, 404, etc.
- `{{errorSchema.properties}}` - error response structure

**Generation:** One file per unique error type

---

### 5. FormRequests (`Http/Requests/{OperationId}Request.php`)

**Pattern:** One FormRequest per operation with requestBody

**Structure:**
```php
class CreateGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Auth in middleware
    }

    public function rules(): array
    {
        return [
            'mode' => ['required', 'string', 'in:single-player,two-player'],
            'playerXId' => ['required', 'string', 'max:255'],
            'playerOId' => ['nullable', 'string', 'max:255', 'required_if:mode,two-player'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Validation Error',
                'message' => 'The request data is invalid',
                'errors' => $validator->errors()->toArray()
            ], 422)
        );
    }
}
```

**Template Variables Needed:**
- `{{operationId}}` - createGame
- `{{schema.properties}}` - request body properties
- `{{property.required}}` - boolean
- `{{property.type}}` - string, integer, boolean, etc.
- `{{property.maxLength}}` - string max length
- `{{property.minimum}}` - number minimum
- `{{property.maximum}}` - number maximum
- `{{property.enum}}` - enum values
- `{{property.format}}` - email, date-time, etc.

**Laravel Rule Mapping:**
```
OpenAPI → Laravel Validation
required: true → 'required'
type: string → 'string'
maxLength: 255 → 'max:255'
enum: [...] → 'in:val1,val2,val3'
format: email → 'email'
format: date → 'date'
minimum: 1 → 'min:1'
pattern: regex → 'regex:/pattern/'
```

**Generation:** One file per operation with requestBody

---

### 6. Request DTOs (`Models/{SchemaName}RequestDto.php`)

**Pattern:** Typed DTO for request bodies

**Structure:**
```php
class CreateGameRequestDto
{
    public function __construct(
        public string $mode,
        public string $playerXId,
        public ?string $playerOId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            mode: $data['mode'],
            playerXId: $data['playerXId'],
            playerOId: $data['playerOId'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'mode' => $this->mode,
            'playerXId' => $this->playerXId,
            'playerOId' => $this->playerOId,
        ];
    }
}
```

**Template Variables Needed:**
- `{{schemaName}}` - CreateGameRequest
- `{{properties}}` - list of properties
- `{{property.name}}` - mode, playerXId, etc.
- `{{property.type}}` - string, int, bool, etc.
- `{{property.required}}` - boolean
- `{{property.nullable}}` - boolean

**Type Mapping:**
```
OpenAPI → PHP 8.1+
string → string
integer → int
number → float
boolean → bool
object → array
array → array
date-time → \DateTime
nullable → ?type
```

**Generation:** One file per request schema

---

### 7. Model DTOs (`Models/{SchemaName}.php`)

**Pattern:** Typed DTO for component schemas

**Structure:**
```php
class Game
{
    public function __construct(
        public string $id,
        public string $status,
        public string $mode,
        public string $playerXId,
        public ?string $playerOId,
        public string $currentTurn,
        public ?string $winner,
        public \DateTime $createdAt,
        public \DateTime $updatedAt,
    ) {}
}
```

**Template Variables:** Same as Request DTOs

**Generation:** One file per component schema

---

### 8. API Interface (`Api/{Tag}Api.php`)

**Pattern:** One interface per tag, methods per operation

**Structure:**
```php
interface GameApi
{
    /**
     * @return CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
     */
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource;

    /**
     * @return GetGame200Resource|ValidationErrorResource|NotFoundErrorResource
     */
    public function getGame(string $gameId): GetGame200Resource|ValidationErrorResource|NotFoundErrorResource;
}
```

**Template Variables Needed:**
- `{{tag}}` - Game (interface: GameApi)
- `{{operations}}` - list of operations in this tag
- `{{operation.name}}` - createGame
- `{{operation.parameters}}` - method parameters
- `{{operation.returnTypes}}` - union of Resource classes

**Key Feature:** Union return types from all response codes!

**Generation:** One file per tag

---

### 9. Security Interfaces (`Security/{SchemeName}Interface.php`)

**Pattern:** One interface per security scheme

**Structure:**
```php
/**
 * Auto-generated from OpenAPI security scheme: bearerHttpAuthentication
 * Type: http, Scheme: bearer, Bearer Format: JWT
 */
interface BearerHttpAuthenticationInterface
{
    public function handle(Request $request, Closure $next);
}
```

**Template Variables Needed:**
- `{{securitySchemeName}}` - bearerHttpAuthentication
- `{{scheme.type}}` - http, apiKey, oauth2
- `{{scheme.scheme}}` - bearer (for http type)
- `{{scheme.bearerFormat}}` - JWT (optional)

**Generation:** One file per unique security scheme

---

## Critical Patterns

### Pattern 1: One Resource Per Operation+Response

**NOT:**
❌ `GameResource` used for all operations returning Game

**YES:**
✅ `CreateGame201Resource` (HTTP 201, Location header)
✅ `GetGame200Resource` (HTTP 200, no headers)

**Why:** Different operations have different HTTP codes and headers even with same data schema.

### Pattern 2: Hardcoded HTTP Code in Resources

**NOT:**
```php
$resource = new GameResource($game);
$resource->httpCode = 201; // Handler sets
```

**YES:**
```php
class CreateGame201Resource extends JsonResource
{
    protected int $httpCode = 201; // Hardcoded in class
}
```

**Why:** Impossible to use wrong HTTP code - it's baked into the class.

### Pattern 3: Header Properties on Resources

**NOT:**
```php
$response->header('Location', $url); // In handler
```

**YES:**
```php
$resource = new CreateGame201Resource($game);
$resource->location = $url; // Handler sets property
// Resource validates in withResponse()
```

**Why:** Resource validates required headers at runtime.

### Pattern 4: Conditional Middleware in Routes

**NOT:**
```php
$router->POST('/games', CreateGameController::class)
    ->middleware(AuthMiddleware::class); // Hardcoded
```

**YES:**
```php
$route = $router->POST('/games', CreateGameController::class);
if ($router->hasMiddlewareGroup('api.middlewareGroup.createGame')) {
    $route->middleware('api.middlewareGroup.createGame');
}
```

**Why:** Developer controls middleware groups in bootstrap/app.php.

### Pattern 5: Union Return Types in Interface

**NOT:**
```php
public function createGame(...): JsonResource; // Too generic
```

**YES:**
```php
public function createGame(...): CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource;
```

**Why:** Compile-time enforcement of valid Resources per operation.

---

## OpenAPI → Code Mapping

### Operations Loop

```mustache
{{#operations}}
{{#operation}}
  operationId: {{operationId}}
  httpMethod: {{httpMethod}}
  path: {{path}}
  hasAuth: {{hasAuth}}

  {{#parameters}}
    {{#isPathParam}} ${{paramName}}: {{dataType}} {{/isPathParam}}
    {{#isQueryParam}} query: {{paramName}} {{/isQueryParam}}
  {{/parameters}}

  {{#hasBodyParam}}
    requestSchema: {{bodyParam.schema.name}}
  {{/hasBodyParam}}

  {{#responses}}
    code: {{code}}
    schema: {{schema.name}}
    {{#headers}}
      name: {{baseName}}
      required: {{required}}
    {{/headers}}
  {{/responses}}
{{/operation}}
{{/operations}}
```

### Resource Generation Logic

For each operation:
```
FOR EACH response code (200, 201, 404, etc.):
  className = {{operationId}}{{code}}Resource
  httpCode = {{code}}
  schema = {{response.schema}}
  headers = {{response.headers}}

  GENERATE: Http/Resources/{{className}}.php
    - protected int $httpCode = {{code}};
    - {{#headers}}public ?string ${{name}} = null;{{/headers}}
    - toArray() from {{schema.properties}}
    - withResponse() validates {{headers}}
```

### Controller Generation Logic

```
FOR EACH operation:
  className = {{operationId}}Controller

  parameters = []
  IF hasPathParams:
    ADD path params to parameters

  requestClass = null
  requestDto = null
  IF hasRequestBody:
    requestClass = {{operationId}}Request
    requestDto = {{schema}}RequestDto

  GENERATE: Http/Controllers/{{className}}.php
```

---

## Summary

**9 Templates Generate:**
1. ✅ Routes file (all routes)
2. ✅ Controllers (per operation)
3. ✅ Resources (per operation+response)
4. ✅ Error Resources (per error type)
5. ✅ FormRequests (per operation with body)
6. ✅ Request DTOs (per request schema)
7. ✅ Model DTOs (per component schema)
8. ✅ API Interface (per tag)
9. ✅ Security Interfaces (per scheme)

**File Count for TicTacToe API:**
- Routes: 1 file
- Controllers: 6 files (6 operations)
- Resources: 17 files (6 success + 5 error types + collection wrappers)
- FormRequests: 3 files (3 operations with bodies)
- DTOs: 5 files (2 request + 3 model)
- API Interface: 1 file (1 tag)
- Security Interface: 1 file (1 scheme)

**Total:** ~34 files for a small API

**Quality:** ✅ PSR-4, ✅ Type-safe, ✅ Contract-enforced, ✅ No post-processing
