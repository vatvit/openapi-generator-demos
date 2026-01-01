---
code: GENDE-013
status: Proposed
dateCreated: 2026-01-01T14:07:32.824Z
type: Feature Enhancement
priority: Low
relatedTickets: GENDE-003,GENDE-007
dependsOn: GENDE-003
implementationNotes: OOTB demo - comes BEFORE custom templates to establish baseline
---

# Create Demo Symfony Project Using php-symfony Generated Code

## 1. Description
### Problem Statement

Each generator option needs its own demo project to:
1. Show real integration patterns
2. Reveal integration limitations
3. Validate generated code works
4. Serve as reference for users

Laravel path has demo projects. Symfony path needs equivalent for OOTB php-symfony generator.

### Goal

Create a demo Symfony project using **default php-symfony generated code** (OOTB) that:
1. Integrates generated code for both TicTacToe and PetShop APIs
2. Demonstrates standard Symfony integration patterns
3. Reveals OOTB integration limitations
4. Works as foundation for future improvements

### Scope

- Create Symfony 7.x project with Docker environment
- Integrate OOTB generated code (no custom templates yet)
- Implement sample handlers to prove it works
- Document integration steps and limitations discovered

### Project Naming Convention

Following the standard: `{framework}-api--{generator}--{variant}/`

```
projects/symfony-api--php-symfony--default/    # This ticket (OOTB)
projects/symfony-api--php-symfony--custom/     # Future (with custom templates)
projects/symfony-api--symfony-max--default/    # Future (custom generator)
```
## 2. Rationale

- **Parity with Laravel** - Laravel has demo project, Symfony should too
- **Validation** - Proves generated code works in real Symfony app
- **Reference** - Shows how to integrate generated libraries
- **Foundation** - Will be used for symfony-max testing later

## 3. Solution Analysis

### Project Structure

```
projects/
├── laravel-api--php-laravel--replaced-tags/    # Laravel demo (existing)
└── symfony-api--php-symfony--default/          # Symfony demo (NEW)
    ├── docker-compose.yml
    ├── Dockerfile
    ├── Makefile
    ├── composer.json
    ├── config/
    │   ├── packages/
    │   ├── routes/
    │   └── services.yaml
    ├── src/
    │   ├── Controller/           # App controllers (if needed)
    │   ├── Handler/              # API handler implementations
    │   └── Kernel.php
    ├── generated/                # Symlink or copy of generated code
    │   ├── tictactoe/
    │   └── petshop/
    └── tests/
        └── Api/                  # API integration tests
```

### Integration Approach

Based on php-symfony generator output:

1. **Bundle Registration** - Register generated OpenAPIServerBundle
2. **Routing** - Import generated routing.yaml
3. **Services** - Import generated services.yaml
4. **Handlers** - Implement ApiInterface for business logic

### Docker Environment

Similar to Laravel demo:
- PHP 8.3-FPM
- Nginx
- MySQL 8.0 (optional)
- Redis (optional)

## 4. Implementation Specification

### Steps

1. **Create Symfony project**
   ```bash
   mkdir -p projects/symfony-api--php-symfony--default
   cd projects/symfony-api--php-symfony--default
   # Use Symfony skeleton or webapp
   ```

2. **Setup Docker environment**
   - docker-compose.yml (app, webserver, db)
   - Dockerfile for PHP 8.3-FPM
   - Makefile with common commands

3. **Integrate generated code**
   - Link/copy generated bundles
   - Register in config/bundles.php
   - Import routing and services

4. **Implement sample handlers**
   ```php
   // src/Handler/TicTacToe/GameManagementHandler.php
   class GameManagementHandler implements GameManagementApiInterface
   {
       public function createGame(...): array|object|null
       {
           // Sample implementation
       }
   }
   ```

5. **Create Makefile**
   ```makefile
   setup:      # Install dependencies
   start:      # Start Docker services
   stop:       # Stop Docker services
   test:       # Run tests
   generate:   # Regenerate APIs
   ```

6. **Add integration tests**
   - Test API endpoints respond
   - Test validation works
   - Test error responses

### Deliverables

| Artifact | Location |
|----------|----------|
| Symfony project | `projects/symfony-api--php-symfony--default/` |
| Docker config | `docker-compose.yml`, `Dockerfile` |
| Makefile | `Makefile` |
| Sample handlers | `src/Handler/` |
| Integration tests | `tests/Api/` |
| README | `README.md` |

## 5. Acceptance Criteria

- [ ] Symfony 7.x project created with Docker environment
- [ ] Both TicTacToe and PetShop APIs integrated
- [ ] `make setup` installs all dependencies
- [ ] `make start` starts development server
- [ ] At least one endpoint per API responds correctly
- [ ] Sample handler implementations provided
- [ ] README documents setup and usage
- [ ] Project structure mirrors Laravel demo where applicable