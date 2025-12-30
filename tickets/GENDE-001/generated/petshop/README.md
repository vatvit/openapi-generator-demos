# Petshop API - Generated Library

Generated from `petshop-extended.yaml` using the **laravel-max** OpenAPI Generator (Phase 7 Complete).

## Namespace: `PetshopApi`

**IMPORTANT**: This generated library uses the **`PetshopApi`** root namespace to avoid conflicts with Laravel's `App` namespace.

All classes use spec-specific namespaces:
- `PetshopApi\Models\*` - DTOs and entities
- `PetshopApi\Api\*` - API interfaces (tag-based)
- `PetshopApi\Http\Controllers\*` - Single-action controllers
- `PetshopApi\Http\Resources\*` - Response transformers
- `PetshopApi\Http\Requests\*` - Validation classes

## Generation Info

- **OpenAPI Spec**: `openapi-generator-specs/petshop/petshop-extended.yaml`
- **Generator**: `laravel-max` (custom generator)
- **Generator Version**: 1.0.0
- **OpenAPI Generator**: 7.10.0
- **Configuration**:
  - `apiPackage`: `PetshopApi`
  - `modelPackage`: `PetshopApi\\Models`

## Generated Files (33 total)

### Models (4 files)
- `app/Models/Pet.php` - Pet entity with id, name, tag
- `app/Models/NewPet.php` - Pet creation DTO (without id)
- `app/Models/Error.php` - Error response model
- `app/Models/User.php` - Default Laravel User model

### API Interfaces (12 files)
Tag-based interface segregation:
- `app/Api/PetsApiApi.php`
- `app/Api/SearchApiApi.php`
- `app/Api/InventoryApiApi.php`
- `app/Api/ManagementApiApi.php`
- `app/Api/RetrievalApiApi.php`
- `app/Api/CreationApiApi.php`
- `app/Api/WorkflowApiApi.php`
- `app/Api/PublicApiApi.php`
- `app/Api/AdminApiApi.php`
- `app/Api/AnalyticsApiApi.php`
- `app/Api/ReportingApiApi.php`
- `app/Api/DetailsApiApi.php`

### Controllers (4 files)
Single-action controllers (one per operation):
- `app/Http/Controllers/FindPetsController.php` - GET /pets
- `app/Http/Controllers/AddPetController.php` - POST /pets
- `app/Http/Controllers/FindPetByIdController.php` - GET /pets/{id}
- `app/Http/Controllers/DeletePetController.php` - DELETE /pets/{id}

### Resources (8 files)
Response transformers for each operation + status code:
- `app/Http/Resources/FindPets200Resource.php` - Success response for GET /pets
- `app/Http/Resources/FindPets0Resource.php` - Error response for GET /pets
- `app/Http/Resources/AddPet200Resource.php` - Success response for POST /pets
- `app/Http/Resources/AddPet0Resource.php` - Error response for POST /pets
- `app/Http/Resources/FindPetById200Resource.php` - Success for GET /pets/{id}
- `app/Http/Resources/FindPetById0Resource.php` - Error for GET /pets/{id}
- `app/Http/Resources/DeletePet204Resource.php` - Success for DELETE /pets/{id}
- `app/Http/Resources/DeletePet0Resource.php` - Error for DELETE /pets/{id}

### FormRequests (1 file)
- `app/Http/Requests/AddPetFormRequest.php` - Validation for POST /pets

### Routes (1 file)
- `routes/petshop-api.php` - API route definitions

## Phase 7 Fixes Applied

All three critical bugs discovered during Laravel integration testing have been fixed:

### ✅ Fix #1: Controllers Include Request Parameter
**Problem**: Controllers didn't include `Request $request` parameter, causing "Undefined variable $request" error.

**Solution**: All controllers now include `Request $request` as first parameter:

```php
public function __invoke(
    Request $request,    // ← Added!
    int $id
): JsonResponse
{
    $resource = $this->handler->findPetById($id);
    return $resource->response($request);  // ← Now defined
}
```

### ✅ Fix #2: Resources Handle Array Responses
**Problem**: Resources for array responses tried to access properties on arrays, causing "Attempt to read property on array" error.

**Solution**: Array responses use `array_map()`:

```php
public function toArray($request): array
{
    /** @var Pet[] $models */
    $models = $this->resource;

    // Response is an array of Pet objects
    return array_map(function($pet) {
        return [
            'name' => $pet->name,
            'tag' => $pet->tag,
            'id' => $pet->id,
        ];
    }, $models);
}
```

### ✅ Fix #3: Error Resources Use Dynamic HTTP Status
**Problem**: Error resources hardcoded `$httpCode = 0`, causing "The HTTP status code '0' is not valid" error.

**Solution**: Error resources read status from Error model:

```php
public function withResponse($request, $response)
{
    // For default/error responses, use dynamic status from Error model
    /** @var Error $model */
    $model = $this->resource;
    $response->setStatusCode($model->code);  // Uses 404, 500, etc.
}
```

## Usage in Laravel Project

To use this generated library in a Laravel 11 application:

### 1. Copy files to Laravel project
```bash
cp -r app/Models/* your-laravel-project/app/Models/
cp -r app/Api/* your-laravel-project/app/Api/
cp -r app/Http/Controllers/* your-laravel-project/app/Http/Controllers/
cp -r app/Http/Resources/* your-laravel-project/app/Http/Resources/
cp -r app/Http/Requests/* your-laravel-project/app/Http/Requests/
cp routes/petshop-api.php your-laravel-project/routes/
```

### 2. Update composer.json PSR-4 autoloading

Add the `PetshopApi` namespace to your project's `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "PetshopApi\\": "app/"
        }
    }
}
```

Then run:
```bash
composer dump-autoload
```

### 3. Update bootstrap/app.php

Register API routes:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/petshop-api.php',  // Add this
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
```

### 4. Implement API interfaces

Create a handler class that implements the generated API interfaces:

```php
namespace App\Handlers;

use PetshopApi\Api\PetsApiApi;
use PetshopApi\Api\SearchApiApi;
// Import all 12 tag interfaces...

class PetsApiHandler implements
    PetsApiApi,
    SearchApiApi,
    // Implement all 12 interfaces...
{
    public function findPets(array $tags, int $limit)
    {
        // Your business logic here
        $pets = /* fetch from database */;
        return new \PetshopApi\Http\Resources\FindPets200Resource($pets);
    }

    public function addPet(\PetshopApi\Models\NewPet $newPet)
    {
        // Your business logic here
    }

    public function findPetById(int $id)
    {
        // Your business logic here
    }

    public function deletePet(int $id)
    {
        // Your business logic here
    }
}
```

### 5. Register service bindings

In `app/Providers/AppServiceProvider.php`:

```php
public function register(): void
{
    // Bind all API interfaces to your handler
    $this->app->bind(\PetshopApi\Api\PetsApiApi::class, \App\Handlers\PetsApiHandler::class);
    $this->app->bind(\PetshopApi\Api\SearchApiApi::class, \App\Handlers\PetsApiHandler::class);
    $this->app->bind(\PetshopApi\Api\InventoryApiApi::class, \App\Handlers\PetsApiHandler::class);
    // Bind all 12 tag interfaces...
}
```

## Validation

All 33 generated PHP files pass PHP 8.4 syntax validation:

```bash
find app/ -name "*.php" -exec php -l {} \; | grep -v "No syntax errors"
# No output = all files valid!
```

## API Endpoints

The generated code supports these endpoints:

- `GET /api/pets` - List all pets (with optional `tags[]` and `limit` query params)
- `POST /api/pets` - Create a new pet
- `GET /api/pets/{id}` - Get pet by ID
- `DELETE /api/pets/{id}` - Delete pet

## Testing

This library has been integrated and tested in:
```
projects/laravel-api--custom-laravel-max--laravel-max/
```

All endpoints verified working with:
- ✅ HTTP status codes (200, 204, 404, 500)
- ✅ JSON response formatting
- ✅ Query parameter handling
- ✅ Request validation
- ✅ Error responses

---

**Generated**: 2025-12-29
**Generator**: laravel-max v1.0.0 (Phase 7 Complete)
**Namespace**: PetshopApi (spec-specific)
