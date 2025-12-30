# Tictactoe API - Laravel Integration Test Project

This is a minimal Laravel 11 application that integrates the **generated tictactoe library** via Composer autoloader.

## Architecture

### Generated Library (Read-Only)
The generated code lives in `../../generated/tictactoe/` and is loaded via PSR-4 autoloading:

```json
"TictactoeApi\\": "../../generated/tictactoe/app/"
```

**Generated files** (do not edit):
- `TictactoeApi\Models\*` - DTOs and PHP 8.1+ enums
- `TictactoeApi\Api\*` - Tag-based API interfaces
- `TictactoeApi\Http\Controllers\*` - Single-action controllers
- `TictactoeApi\Http\Resources\*` - Response transformers
- `TictactoeApi\Http\Requests\*` - FormRequest validation

**Generated routes**: Included via `routes/api.php`

### Project-Specific Code
Custom implementation code goes in this project:

- `app/Handlers/` - Implement the generated API interfaces
- `app/Providers/AppServiceProvider.php` - Bind interfaces to handlers
- `tests/` - Integration tests

## Setup

1. Install dependencies:
   ```bash
   composer install
   ```

2. Create handler classes that implement the generated interfaces
3. Bind interfaces in `app/Providers/AppServiceProvider.php`
4. Run tests:
   ```bash
   ./vendor/bin/phpunit
   ```

## Key Features

✅ **PHP 8.1+ Enums**: Generated enums for Mark, GameMode, GameStatus, Winner
✅ **Enum Validation**: FormRequests include `in:value1,value2` validation rules
✅ **Min/Max Validation**: Numeric and string constraints from OpenAPI spec
✅ **Clean Separation**: Generated code loaded via autoloader, no file copying needed
