# Phase 8: Tictactoe Spec Generation

Testing the laravel-max generator with the tictactoe.json spec to discover and fix issues with more complex OpenAPI features.

## Objectives

1. Generate code from tictactoe.json spec
2. Discover what breaks or generates incorrectly
3. Document all issues found
4. Create fixes for critical issues
5. Update test suite to cover new features

## Tictactoe Spec Complexity

### Operations: 10
```
GET    /games                              - List games (pagination)
POST   /games                              - Create game
GET    /games/{gameId}                     - Get game details
DELETE /games/{gameId}                     - Delete game
GET    /games/{gameId}/board               - Get board state
GET    /games/{gameId}/board/{row}/{column} - Get square (multi-param)
PUT    /games/{gameId}/board/{row}/{column} - Make move (multi-param)
GET    /games/{gameId}/moves               - Move history
GET    /players/{playerId}/stats           - Player stats
GET    /leaderboard                        - Leaderboard
```

### New Features vs. Petshop

| Feature | Petshop | Tictactoe | Impact |
|---------|---------|-----------|--------|
| **Enums** | ❌ None | ✅ 4 enums | Need PHP enum generation |
| **Response Headers** | ❌ None | ✅ Required (X-Total-Count, Location) | Already supported! |
| **Validation Rules** | ✅ Basic (required) | ✅ Advanced (min/max) | FormRequest validation |
| **UUID Format** | ❌ None | ✅ playerId: uuid | Type hints/validation |
| **Nested Arrays** | ✅ Simple array | ✅ Array of arrays (board) | Complex type handling |
| **Multi Path Params** | ✅ Single ({id}) | ✅ Multiple ({gameId}/{row}/{column}) | Route/controller params |
| **Pagination** | ✅ Simple (limit) | ✅ Full (page, limit) | Query param extraction |

### Schemas: 25 Models
```
- coordinate (integer with min/max)
- mark (enum: '.', 'X', 'O')
- board (array of arrays)
- winner (enum)
- status (object)
- gameStatus (enum: pending, in_progress, completed, abandoned)
- gameMode (enum: pvp, ai_easy, ai_medium, ai_hard)
- player (object)
- game (object)
- createGameRequest (object)
- gameListResponse (object with pagination metadata)
- move (object)
- moveListResponse (object)
- playerStats (object)
- leaderboard (object)
- ... (10 more)
```

### Tags: 4
- Tic Tac (main operations)
- Gameplay (core game actions)
- Game Management (CRUD)
- Statistics (stats and leaderboards)

## Expected Issues

### High Priority (Will Likely Break)

**1. Enum Generation**
- **Problem**: PHP 8.1+ has native enum support, generator likely doesn't use it
- **Current Behavior**: Probably generates string constants or ignores enums
- **Desired**: Generate PHP 8.1 enum classes
```php
enum Mark: string {
    case Empty = '.';
    case X = 'X';
    case O = 'O';
}
```

**2. Nested Array Types**
- **Problem**: `board` is `array<array<string>>` (2D array)
- **Current Behavior**: May generate incorrect type hints
- **Desired**: Proper nested array handling

**3. Multi-Path Parameters**
- **Problem**: `/games/{gameId}/board/{row}/{column}` has 3 path params
- **Current Behavior**: Unknown - may work or may have ordering issues
- **Desired**: Correct parameter order in controller

**4. UUID Format Validation**
- **Problem**: `playerId` has `format: uuid`
- **Current Behavior**: Probably ignores format, treats as string
- **Desired**: Add UUID validation in FormRequest

**5. Min/Max Validation**
- **Problem**: `coordinate` has `minimum: 1, maximum: 3`
- **Current Behavior**: Unknown - may not generate validation rules
- **Desired**: Add min/max rules in FormRequest

### Medium Priority (May Have Issues)

**6. Required Response Headers**
- **Problem**: `X-Total-Count` is marked as required
- **Current Behavior**: Header support exists (Phase 7), but "required" may not enforce
- **Desired**: Runtime validation that required headers are set

**7. Pagination Metadata**
- **Problem**: `gameListResponse` has nested `metadata` object with `page`, `limit`, `total`
- **Current Behavior**: Should work as nested object
- **Desired**: Proper nested object handling

**8. OpenAPI 3.1.0**
- **Problem**: Tictactoe uses OpenAPI 3.1.0 (petshop uses 3.0.0)
- **Current Behavior**: Unknown - may have compatibility issues
- **Desired**: Support both 3.0 and 3.1

### Low Priority (Likely OK)

**9. Multiple Tags per Operation**
- **Current Behavior**: Should work (petshop also has this)
- **Expected**: ✅ OK

**10. Query Parameter Defaults**
- **Current Behavior**: Phase 7 fixed this
- **Expected**: ✅ OK

## Testing Plan

### Step 1: Generate Code
```bash
cd tickets/GENDE-001

# Update generate-pom.xml for tictactoe
# Set:
#   inputSpec: ../../openapi-generator-specs/tictactoe/tictactoe.json
#   apiPackage: TictactoeApi
#   modelPackage: TictactoeApi\Models
#   output: ../generated/tictactoe

# Generate
cd poc
docker run --rm \
    -v $(pwd)/../..:/workspace \
    -w /workspace/tickets/GENDE-001/poc \
    maven:3.9-eclipse-temurin-21 \
    mvn -f generate-pom.xml generate-sources
```

### Step 2: Validate Structure
```bash
cd tests
./validate-generated-structure.sh ../generated/tictactoe TictactoeApi
```

### Step 3: Manual Code Review
Review generated code for:
- Enum handling
- Nested arrays
- Multi-path parameters
- Validation rules
- UUID format handling

### Step 4: Document Issues
Create `docs/PHASE-8-FINDINGS.md` with:
- List of all issues discovered
- Severity (Critical, High, Medium, Low)
- Examples of incorrect code
- Proposed fixes

### Step 5: Prioritize Fixes
Decide which issues to fix in Phase 8 vs. defer to later

### Step 6: Implement Fixes
For critical issues:
- Update generator code (LaravelMaxGenerator.java)
- Update templates (model.mustache, etc.)
- Rebuild and regenerate
- Validate fixes

### Step 7: Update Tests
Add test cases for:
- Enum generation
- Nested array handling
- Multi-path parameter handling
- Validation rules

## Success Criteria

**Minimum (Phase 8a)**:
- ✅ Code generates without errors
- ✅ All PHP files pass syntax validation
- ✅ Structure validation passes
- ✅ Multi-path parameters work
- ✅ Enums generate (even if not PHP 8.1 enums yet)

**Ideal (Phase 8b)**:
- ✅ All of Phase 8a
- ✅ PHP 8.1 enum support
- ✅ Nested array type hints correct
- ✅ UUID validation in FormRequests
- ✅ Min/max validation in FormRequests
- ✅ Required headers enforced

**Perfect (Phase 8c)**:
- ✅ All of Phase 8b
- ✅ Laravel integration tests pass for tictactoe
- ✅ Documentation updated
- ✅ Test coverage at 100%

## Timeline

- **Phase 8a** (Discovery): 1-2 hours
  - Generate code
  - Document all issues
  - Categorize by severity

- **Phase 8b** (Critical Fixes): 2-3 hours
  - Fix multi-path parameters (if broken)
  - Basic enum support
  - Validation rules

- **Phase 8c** (Polish): 2-4 hours
  - PHP 8.1 enums
  - UUID validation
  - Nested array handling
  - Tests

**Total**: 5-9 hours for complete Phase 8

## Next Steps

1. ✅ Create this plan document
2. 🔄 Generate code from tictactoe.json
3. 📋 Document findings
4. 🔧 Implement fixes
5. ✅ Validate with tests
6. 📚 Update documentation

---

**Created**: 2025-12-29
**Status**: Planning
