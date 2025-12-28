# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 📚 Key Documentation

**CRITICAL: Read these files before working on this project:**

### Core Documents

1. **`GOAL.md`** - Project goal and success criteria
   - Main objective: Create contract-enforced PHP libraries from OpenAPI specs
   - Success definition and critical success criteria
   - Quality requirements overview

2. **`GOAL_MAX.md`** - Laravel-focused solution specification
   - Detailed specification of ideal Laravel library
   - All components and patterns required
   - Security middleware approach
   - Manual integration philosophy

3. **`CLAUDE.md`** (this file) - Implementation details
   - Repository structure and organization
   - Development guidelines and critical rules
   - Quality requirements (detailed)

### Reference Implementation (ETALON)

**📌 `generated-examples/laravel-max/`** - **THE IDEAL REFERENCE IMPLEMENTATION**

This is the **etalon (standard)** - the maximum quality solution that demonstrates:
- ✅ All patterns from `GOAL_MAX.md` implemented correctly
- ✅ One controller per operation pattern
- ✅ Complete library/application separation
- ✅ Authentication middleware with interface/stub/validator
- ✅ Comprehensive test coverage (31 tests, 131 assertions)
- ✅ Full documentation

**Key files in laravel-max:**
- **`generated-examples/laravel-max/README.md`** - Overview and quick start
- **`generated-examples/laravel-max/ARCHITECTURE.md`** - Complete architecture documentation
  - Controller patterns (one per operation)
  - Library vs Application separation (critical architectural decision)
  - Request/response flow
  - Design patterns used
  - Component responsibilities

**⚠️ IMPORTANT:** When implementing generators or templates, **compare against laravel-max**. It demonstrates the target quality and architecture we want generators to produce.

### Generator Documentation

4. **`openapi-generator-server-templates/GENERATORS-COMMON.md`** - Generator concepts
   - Template loop types
   - Customization via `files` config
   - Common patterns across all generators

5. **Generator-Specific Analyses:**
   - `openapi-generator-server-templates/openapi-generator-server-php-laravel-default/GENERATOR-ANALYSIS.md`
     - php-laravel generator capabilities
     - Quality score: 85%
     - Recommended for production use

   - `openapi-generator-server-templates/openapi-generator-server-php-lumen-default/GENERATOR-ANALYSIS.md`
     - php-lumen generator capabilities
     - Quality score: 17%
     - Requires extensive custom development

**When analyzing a new generator:**
- Extract default templates to `openapi-generator-server-templates/openapi-generator-server-{generator}-default/`
- Create `GENERATOR-ANALYSIS.md` following the same structure
- Reference `GENERATORS-COMMON.md` to avoid duplicating common concepts
- **Compare against `GOAL_MAX.md` and `laravel-max` reference implementation**
- Document gaps between generator capabilities and ideal solution

---

## ⚠️ Critical Rules

**MUST follow these rules at all times:**

1. **NO Claude Co-Contributor in Git Commits**
   - Never add "Co-Authored-By: Claude" or similar attribution to git commits
   - Do not add any Claude-related notices or footers to commit messages

2. **Always Use Docker - Local Host Has No Development Tools**
   - The local host does NOT have `php`, `node`, `npm`, `composer`, or other development tools installed
   - ALWAYS run commands via Docker containers
   - NEVER attempt to run `php`, `node`, `npm`, `composer` directly on the host

3. **Use Make Commands for Reproducibility**
   - Prefer using `make` commands defined in Makefiles
   - These commands ensure reproducible environments via Docker
   - When in doubt, check available commands with `make help`

4. **Multiple Independent Git Repositories**
   - The `openapi-generator-specs/`, `openapi-generator-generators/`, and `openapi-generator-server-templates/` directories are **separate git repositories**
   - They are NOT part of the main `openapi-generator-demos` git repository
   - They are cloned in the same folder only for development convenience
   - **When committing/pushing changes:**
     - Changes to files in `openapi-generator-specs/` → `cd openapi-generator-specs && git commit/push`
     - Changes to files in `openapi-generator-generators/` → `cd openapi-generator-generators && git commit/push`
     - Changes to files in `openapi-generator-server-templates/` → `cd openapi-generator-server-templates && git commit/push`
     - Changes to root files or `projects/` → git operations in the main repo root
   - Always execute git commands in the appropriate repository directory

5. **Makefile Independence and Hierarchy**
   - Each Makefile is kept independent and focused on its specific scope at the appropriate level
   - **Hierarchy principle:** Place Makefile at the level that matches its scope
     - Related to ALL generators but generator concerns only → `openapi-generator-generators/Makefile`
     - Related to ONE specific generator (php-laravel) → `openapi-generator-generators/php-laravel/Makefile`
     - Related to ALL projects but project concerns only → `projects/Makefile` (if needed)
     - Related to ONE specific project → `projects/laravel-api--php-laravel--replaced-tags/Makefile`
     - Orchestrates across ALL components → Root `Makefile`
   - **Examples:**
     - `openapi-generator-generators/php-laravel/Makefile` contains ONLY php-laravel generator commands (generate, extract-templates, check-version)
     - `projects/laravel-api--php-laravel--replaced-tags/Makefile` contains ONLY that Laravel project's commands (setup, start, stop, test)
     - Root `Makefile` delegates to specific Makefiles and orchestrates workflows
   - **DO NOT mix concerns** - don't add Laravel commands to generator Makefile, don't add generator commands to project Makefile
   - This ensures reusability and clarity: each component can be used independently

## Repository Overview

This is a demonstration repository showcasing various OpenAPI Generator workflows and approaches. The repository contains multiple demo projects that demonstrate different strategies for generating and integrating server code from OpenAPI specifications.

### Repository Purpose

The goal is to demonstrate **separation of concerns** in OpenAPI-driven development by keeping four aspects independent:
1. **Project** - The application that consumes generated code
2. **OpenAPI Spec** - The API contract definition
3. **Generator** - The code generation logic and scripts
4. **Templates** - Mustache templates for different architectural approaches

---

## Library Quality Requirements

This section defines the quality attributes and implementation requirements for generated libraries. See `GOAL.md` for the high-level goal definition.

### Integration Requirements

**Easy Installation & Integration:**
- ✅ Installable via Composer as a dependency
- ✅ Simple integration into existing Laravel projects
- ✅ Minimal configuration required
- ✅ Clear documentation and examples

**Complete API Implementation:**
- ✅ Provides **everything** needed to expose the API in a Laravel project
- ✅ No manual route definitions required
- ✅ No manual request/response handling required
- ✅ Just implement business logic, framework handles the rest

### API Contract Enforcement

**Force Developer to Follow Specification:**

The library must make it **impossible or highly difficult** to break the API contract by:

1. **Interface Contracts** - Developer implements interfaces, not modifies generated code
   - Each operation has a typed interface
   - Method signatures match the API spec exactly
   - Changing signatures = compilation error

2. **Request DTOs** - All endpoints use structured Request objects
   - Auto-generated from OpenAPI request body schemas
   - Type-safe properties based on spec
   - Validation enforces schema constraints
   - Developer cannot accept invalid data

3. **Response Structures** - Developer must return spec-compliant responses
   - Response factories enforce response schema
   - Type-safe response objects/DTOs
   - HTTP status codes from spec
   - Developer cannot return wrong structure

4. **Type Safety** - PHP 8.1+ strict typing throughout
   - Typed properties
   - Typed parameters
   - Typed return values
   - IDE autocomplete and static analysis support

**Example Flow:**
```php
// Generated Interface (from OpenAPI spec)
interface CreatePetApiInterface
{
    public function createPet(CreatePetRequest $request): CreatePetResponse;
}

// Developer Implementation (business logic only)
class CreatePetHandler implements CreatePetApiInterface
{
    public function createPet(CreatePetRequest $request): CreatePetResponse
    {
        // $request->name is typed (string)
        // $request->age is typed (int|null) if optional
        // Cannot access properties not in spec

        $pet = Pet::create(['name' => $request->name]);

        // Must return CreatePetResponse (enforced by type)
        // Cannot return wrong status code or structure
        return CreatePetResponse::created($pet);
    }
}
```

### Code Quality Requirements

**Follow Best Practices & Design Principles:**

**SOLID Principles:**
- **S**ingle Responsibility - Each class has one purpose
- **O**pen/Closed - Generated code open for extension, closed for modification
- **L**iskov Substitution - Interfaces enable substitutability
- **I**nterface Segregation - Focused interfaces per operation
- **D**ependency Inversion - Depend on interfaces, not implementations

**DRY (Don't Repeat Yourself):**
- Shared validation logic
- Reusable DTOs and response factories
- Common base classes where appropriate

**KISS (Keep It Simple, Stupid):**
- Clear, readable generated code
- Minimal abstractions
- No over-engineering

**PSR Standards:**
- ✅ **PSR-4** - Autoloading standard (file structure matches namespaces)
- ✅ **PSR-12** - Code style guide (if possible)
- ✅ Proper namespacing and class organization

**Laravel Best Practices:**
- Use Laravel's Request validation
- Follow Laravel naming conventions
- Compatible with Laravel's dependency injection container
- Leverage Laravel's service providers
- Use Laravel's Response helpers
- Follow Laravel directory structure conventions

**Laravel Framework Structures (Support IF POSSIBLE):**

The library should leverage Laravel's framework structures when applicable:

1. **Laravel Resources** - For response transformation
   - Use `Illuminate\Http\Resources\Json\JsonResource` for API responses
   - Transform models to JSON according to OpenAPI schema
   - Support resource collections for array responses

2. **Route Middleware** - For request processing
   - Support Laravel middleware in generated routes
   - Allow authentication middleware (`auth:api`, `auth:sanctum`)
   - Allow throttling middleware (`throttle:60,1`)
   - Allow custom middleware from spec (via extensions if needed)

3. **Form Requests** - For validation
   - Use `Illuminate\Foundation\Http\FormRequest` for complex validation
   - Auto-generate validation rules from OpenAPI schema
   - Support custom validation messages
   - Support authorization logic

4. **Route Groups** - For route organization
   - Support route prefixes (e.g., `/api/v1`)
   - Support route naming
   - Support middleware groups

5. **Service Providers** - For configuration
   - Auto-discovery support (`extra.laravel.providers` in composer.json)
   - Route registration
   - Dependency injection bindings

6. **API Resources** - Type-safe response transformations
   ```php
   // Example: Generated resource
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

7. **Exception Handling** - Laravel-compatible errors
   - Use Laravel's exception handler
   - Return JSON error responses matching OpenAPI error schemas
   - Support validation exceptions

**Implementation Priority:**
- ✅ **MUST HAVE:** Routes, Middlewares, Service Providers
- ✅ **SHOULD HAVE:** Form Requests (validation), Resources (response transformation)
- ⚠️ **NICE TO HAVE:** Route groups, custom middleware configuration

**Note:** If the generator cannot support a Laravel structure, document the limitation clearly.

### Generated Library Components

The library must provide:

1. **Routes** - Route definitions pointing to generated controllers
   ```php
   Route::post('/pets', [CreatePetController::class, 'createPet']);
   ```

2. **Controllers** - Separate controller classes (NOT inline closures)
   - One controller per operation (preferred) OR per resource group
   - Inject business logic interfaces
   - Handle HTTP layer (validation, request parsing, response formatting)

3. **API Interfaces** - Contracts for business logic implementations
   ```php
   interface CreatePetApiInterface {
       public function createPet(CreatePetRequest $request): CreatePetResponse;
   }
   ```

4. **Request DTOs** - Typed data structures from OpenAPI request schemas
   ```php
   class CreatePetRequest {
       public function __construct(
           public string $name,
           public ?int $age,
       ) {}
   }
   ```

5. **Response DTOs/Factories** - Type-safe response structures
   ```php
   class CreatePetResponse {
       public static function created(Pet $pet): JsonResponse;
       public static function validationError(array $errors): JsonResponse;
   }
   ```

6. **Validators** - Request validation based on OpenAPI schema
   - Automatic validation rules from spec
   - Type constraints (string, integer, array, etc.)
   - Length constraints (minLength, maxLength)
   - Value constraints (minimum, maximum, pattern)
   - Required vs optional fields

7. **Model DTOs** - Data transfer objects from OpenAPI components/schemas
   ```php
   class Pet {
       public function __construct(
           public int $id,
           public string $name,
           public ?string $tag,
       ) {}
   }
   ```

8. **Dependency Injection Setup** - Service provider or binding configuration
   - Map interfaces to implementations
   - Laravel service container integration

### Current Approach: Generator Comparison

To achieve these quality requirements, we're:

1. **Evaluating different OpenAPI generators** (php-laravel, php-lumen, php-symfony, etc.)
2. **Creating custom templates** for each generator to meet our quality requirements
3. **Building demo Laravel projects** to test and compare generated libraries
4. **Documenting capabilities and limitations** of each generator

**Why compare generators?**
- Different generators have different capabilities (per-operation files vs per-tag files)
- Template flexibility varies between generators
- Code generation quality differs
- We want to find the best tool for our requirements

**Progress Status:**

**✅ php-laravel Generator:**
- Custom templates created (`openapi-generator-server-php-laravel`)
- Meets all library requirements
- Generates high-quality, contract-enforced libraries
- Reference project: `laravel-api--php-laravel--replaced-tags`

**✅ php-lumen Generator:**
- Custom templates created (`openapi-generator-server-php-lumen-package`)
- Templates adapted to generate Laravel-compatible packages
- Working demo project exists
- Reference project: `laravel-api--php-lumen--laravel-templates`
- Note: php-lumen generator repurposed to create Laravel packages (not Lumen apps)

**🔮 Future Generators:**
- php-symfony, php (generic), custom generators
- Only if they can meet our quality requirements

---

### Repository Structure

```
openapi-generator-demos/
├── openapi-generator-specs/              # OpenAPI specifications (separate git repo, gitignored)
│                                          # Contains demo OpenAPI specification files
├── openapi-generator-generators/         # Generator scripts and Makefiles (separate git repo, gitignored)
│                                          # Custom generators, scripts, and generation instructions
├── openapi-generator-server-templates/   # Custom templates per generator (separate git repo, gitignored)
│   ├── openapi-generator-server-php-laravel/        # php-laravel custom templates
│   ├── openapi-generator-server-php-lumen-package/  # php-lumen custom templates
│   └── openapi-generator-server-php-lumen-default/  # php-lumen default (for reference)
├── generated-examples/                   # Reference implementations (committed to git)
│   └── laravel-max/                      # 🏆 ETALON - Ideal Laravel library reference
│                                         # Shows maximum quality expected from generators
│                                         # All patterns from GOAL_MAX.md implemented
│                                         # Use this as comparison when building generators
└── projects/                             # Demo applications that consume generated libraries
    └── laravel-api--example--laravel-max/ # Example app using laravel-max library
```

**IMPORTANT: generated-examples/ vs generated/ (deprecated)**
- **`generated-examples/`** - Reference implementations committed to git (like `laravel-max`)
- **`generated/`** - (Deprecated) Was used for temporary generation output, now gitignored
- Future: Generated libraries will be published to Composer repository/artifactory

**IMPORTANT:** The three `openapi-generator-*` directories are **gitignored** and maintained as separate git repositories. Clone them separately to work with this project.

**Key Principle: Separation of Concerns**
- OpenAPI specs, generators, templates, and projects are independently versioned
- Reusable across multiple projects
- Clean comparison between different generator approaches
- This separation allows independent versioning and reuse across different projects

### Current Demos

#### laravel-api--php-laravel--replaced-tags

Uses the **php-laravel** OpenAPI generator with:
- **Custom templates** from `openapi-generator-server-templates/openapi-generator-server-php-laravel/`
- **Pre-processing script** that replaces OpenAPI spec tags for specific internal requirements
- **Custom integration** showing Interface-First Architecture with Laravel dependency injection
- Demonstrates the php-laravel generator's capability to create contract-enforced libraries

**Key Features:**
- One controller per operation pattern
- Type-safe request/response DTOs
- Interface-based business logic separation
- Comprehensive validation

#### laravel-api--php-lumen--laravel-templates

Uses the **php-lumen** OpenAPI generator (repurposed for Laravel packages) with:
- **Custom templates** from `openapi-generator-server-templates/openapi-generator-server-php-lumen-package/`
- **Laravel package generation** using php-lumen generator's template structure
- Demonstrates alternative approach: using php-lumen generator to create Laravel-compatible libraries

**Key Features:**
- php-lumen generator with Laravel-specific templates
- Package-oriented code generation
- Integration with Laravel 12
- Docker-based development environment

**Note:** Despite the "lumen" generator name, the custom templates produce Laravel-compatible packages, not Lumen applications.

### Key Concepts

**Code Generation Workflow:**
1. OpenAPI specs are stored in `openapi-generator-specs/` (separate cloned repo)
2. Pre-processing scripts (in `openapi-generator-generators/`) may modify specs before generation
3. Generators use templates from `openapi-generator-server-templates/` (multiple approaches available)
4. Generated code outputs to `generated/` directory
5. Demo applications in `projects/` integrate the generated code via PSR-4 autoloading

**Future Architecture:**
- Generated libraries will be versioned and published to a repository/artifactory
- Currently `generated/` is gitignored, but versioned artifacts are the long-term goal

**Generated Code Integration:**
- Generated code is organized by generator type:
  - php-laravel: `generated/php-laravel/`
  - php-lumen: `generated/php-lumen/`
- Generated namespaces: `PetStoreApiV2\Server\` and `TicTacToeApiV2\Server\`
- **php-laravel project:** Autoloaded from `../generated/php-laravel/{api}/lib/` (see `composer.json`)
- **php-lumen project:** Autoloaded from `../generated/php-lumen/{api}/lib/` (see `composer.json`)
- Business logic implementations live in `app/Api/{ApiName}/`
- Dependency injection bindings in `app/Providers/AppServiceProvider.php` map generated interfaces to business logic implementations

## Development Commands

### Root-Level Commands

From the repository root, you can use these convenience commands:

```bash
make help                    # Show all available commands
make validate-spec           # Validate OpenAPI specifications
make clean                   # Clean generated files
make test-complete           # Run complete test: validate → generate → test
```

#### php-laravel Generator Commands (Default Project)

```bash
# Code generation (php-laravel generator)
make generate-server         # Generate all API server code (PetStore + TicTacToe)
make generate-petshop        # Generate only PetStore API server
make generate-tictactoe      # Generate only TicTacToe API server

# Laravel application (laravel-api--php-laravel--replaced-tags)
make setup-laravel           # Setup Laravel application
make start-laravel           # Start Laravel development environment
make stop-laravel            # Stop Laravel development environment
make logs-laravel            # Show Laravel application logs
make test-laravel            # Test API endpoints with curl
make test-laravel-phpunit    # Run PHPUnit tests
make dumpautoload            # Refresh composer autoload
```

#### php-lumen Generator Commands (Laravel Packages)

```bash
# Code generation (php-lumen generator → Laravel packages)
make generate-lumen-laravel           # Generate all Laravel packages (PetStore + TicTacToe)
make generate-lumen-laravel-petshop   # Generate only PetStore package
make generate-lumen-laravel-tictactoe # Generate only TicTacToe package

# Laravel application (laravel-api--php-lumen--laravel-templates)
make setup-lumen-laravel       # Setup Laravel application
make start-lumen-laravel       # Start Laravel development environment
make stop-lumen-laravel        # Stop Laravel development environment
make test-lumen-laravel-phpunit # Run PHPUnit tests
```

#### Generator Utilities

```bash
make extract-templates         # Extract default PHP templates
make extract-laravel-templates # Extract default php-laravel templates
make extract-lumen-templates   # Extract default php-lumen templates
make check-version             # Verify generator version
make update-generator-version  # Update to new generator version
```

### Laravel Applications

**All Laravel development should be done via Docker.** Both demo applications use docker-compose with services for app, webserver (nginx), database (MySQL), and Redis.

#### php-laravel Project

Navigate to the php-laravel generator demo:
```bash
cd projects/laravel-api--php-laravel--replaced-tags
```

#### php-lumen Project (Laravel Templates)

Navigate to the php-lumen generator demo (using Laravel templates):
```bash
cd projects/laravel-api--php-lumen--laravel-templates
```

**Setup and Start:**
```bash
make setup      # Install dependencies and setup Laravel (runs composer install in Docker)
make start      # Start all Docker services (app, webserver, db, redis)
make stop       # Stop all Docker services
```

**Testing:**
```bash
make test-phpunit      # Run PHPUnit tests (unit and feature tests)
make test-endpoints    # Test API endpoints with curl
```

**Other Commands:**
```bash
make logs              # View application logs
make dumpautoload      # Refresh composer autoload files (required after adding new classes)

# Running arbitrary artisan commands:
docker-compose exec app php artisan <command>

# Examples:
docker-compose exec app php artisan route:list
docker-compose exec app php artisan tinker
docker-compose exec app php artisan migrate
```

**Running Tests for a Single File:**
```bash
docker-compose exec app php artisan test tests/Feature/YourTestFile.php
```

### NPM/Node Commands

**CRITICAL:** Never run `node` or `npm` commands directly on localhost. Always use Docker:

```bash
# Build frontend assets
docker run --rm -v $(pwd):/app -w /app node:20 npm run build

# Run development server
docker run --rm -v $(pwd):/app -w /app -p 5173:5173 node:20 npm run dev
```

## Architecture

### OpenAPI-Driven Development (Laravel Demos)

Both Laravel demo projects follow an **Interface-First Architecture**. The architecture is most fully developed in `laravel-api--php-laravel--replaced-tags`:


1. **Generated Interfaces** define operation contracts (from OpenAPI spec)
   - Located in `generated/{api}/lib/Api/`
   - Example: `PetStoreApiV2\Server\Api\FindPetsApiInterface`
   - Generated response factories enforce API spec compliance

2. **Business Logic Implementations** implement these interfaces
   - Located in `app/Api/{ApiName}/`
   - Example: `App\Api\PetStore\FindPetsApi implements FindPetsApiInterface`
   - Type-safe responses via generated response factories

3. **Dependency Injection** wires interfaces to implementations
   - Configured in `app/Providers/AppServiceProvider.php`
   - Laravel's service container resolves dependencies automatically

4. **Generated Controllers/Routes** handle HTTP layer
   - Controllers are generated and use constructor injection to get implementations
   - Routes are registered via generated service providers or route files

### Adding a New Demo Project

Each demo in `projects/` should showcase a different approach or generator configuration:

1. Create a new directory in `projects/` with a descriptive name (e.g., `{project-type}--{generator}--{approach}`)
2. Configure the generator and templates for the specific approach
3. Generate code and integrate it into the project
4. Document the approach in the project's README
5. Update this CLAUDE.md with information about the new demo

### Adding a New API Operation (Laravel Demos)

When adding a new operation to an existing API in either Laravel demo:

1. Update the OpenAPI spec in `openapi-generator-specs/`
2. Run pre-processing script (if using tag replacement)
3. Regenerate code (output to `generated/`)
4. Run `make dumpautoload` to refresh PSR-4 autoloader
5. Create implementation class in `app/Api/{ApiName}/` implementing the new generated interface
6. Register binding in `app/Providers/AppServiceProvider.php`
7. Laravel routes and controllers are auto-generated

### Configuration Files (Laravel Demos)

Both Laravel demo projects have generator configuration files:

**php-laravel project:** `projects/laravel-api--php-laravel--replaced-tags/openapi-generator-configs/`
- `petshop-server-config.json`
- `tictactoe-server-config.json`

**php-lumen project:** `projects/laravel-api--php-lumen--laravel-templates/openapi-generator-configs/`
- `petshop-lumen-laravel-config.json`
- `tictactoe-lumen-laravel-config.json`

These JSON files configure the OpenAPI generator:
- Package namespaces (`invokerPackage`, `modelPackage`, `apiPackage`)
- Naming conventions (`variableNamingConvention: "camelCase"`)
- Custom file mappings for response interfaces/factories
- Generated code metadata (version, license, etc.)

Each demo project may have its own configuration approach depending on the generator used.

## Docker Services (Laravel Demos)

Both Laravel demo applications run in multi-container environments with the same structure:

- **app**: PHP 8.3-FPM application container
- **webserver**: Nginx on port 8000
- **db**: MySQL 8.0 on port 3306
  - Database: `laravel_api`
  - User: `laravel` / Password: `password`
- **redis**: Redis on port 6379

Applications are accessible at: `http://localhost:8000` (only one can run at a time on the same ports)

## Initial Setup

This repository structure uses multiple independent git repositories co-located in one folder for development convenience.

**Clone all repositories:**

1. Clone the main demos repository:
   ```bash
   git clone <demos-repo-url> openapi-generator-demos
   cd openapi-generator-demos
   ```

2. Clone the three separate repositories into their respective directories:
   ```bash
   git clone <specs-repo-url> openapi-generator-specs
   git clone <generators-repo-url> openapi-generator-generators
   git clone <templates-repo-url> openapi-generator-server-templates
   ```

3. Run code generation:
   ```bash
   make generate-server
   ```

4. Set up the demo project(s) you want to work with:
   ```bash
   make setup-laravel
   make start-laravel
   ```

**Important:** Each directory (`openapi-generator-specs/`, `openapi-generator-generators/`, `openapi-generator-server-templates/`) has its own `.git` directory and is a completely independent repository.

## Important Notes

- **Separation Philosophy:** The `openapi-generator-*` directories are separate git repositories (gitignored in this repo) to demonstrate independent versioning and reusability
- The `generated/` directory is gitignored and should be regenerated as needed
  - **Future goal:** Generated libraries will be versioned and published to a repository/artifactory instead of being gitignored
- After regenerating code in a Laravel project, always run `make dumpautoload` to update composer's autoload mappings
- Generated code should never be manually edited; customize via templates in `openapi-generator-server-templates/`
- Business logic goes in `app/Api/` implementations, not in generated code
- Both Laravel demos use PHP 8.3+ features (typed properties, constructor property promotion, etc.)
- Tag replacement pre-processing allows customization of OpenAPI specs before code generation (used in php-laravel demo)
