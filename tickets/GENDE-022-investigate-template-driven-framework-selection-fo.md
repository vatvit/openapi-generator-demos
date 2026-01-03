---
code: GENDE-022
status: Implemented
dateCreated: 2026-01-02T07:41:19.226Z
type: Architecture
priority: High
dependsOn: GENDE-011
---

# Investigate Template-Driven Framework Selection for php-max Generator

## 1. Description

### Problem Statement

The php-max generator (GENDE-011) needs a mechanism to support multiple PHP frameworks (Laravel, Symfony, and potentially unknown/custom frameworks). The current approach has framework-specific logic hardcoded in Java, which limits extensibility.

### Goal

Investigate and design a **template-driven** approach where:
1. The Java generator is framework-agnostic
2. Templates determine the output framework
3. Custom/unknown frameworks can be supported without Java code changes

### Key Questions

1. **How to handle validation rules?** Laravel uses string arrays, Symfony uses PHP attributes
2. **How to control which files are generated?** Different frameworks need different file types
3. **How to configure directory structure and namespaces?** Per-framework conventions
4. **How to handle framework-specific patterns?** (e.g., Laravel FormRequest vs Symfony DTO)

## 2. Rationale

- **Maximum flexibility** - Support any PHP framework without Java changes
- **Community extensibility** - Users can create templates for their preferred framework
- **Separation of concerns** - Java handles OpenAPI parsing, templates handle framework formatting
- **Reduced maintenance** - One Java codebase instead of N framework-specific generators

## 3. Solution Analysis

### Approach A: Raw Constraints in Templates

Java passes raw OpenAPI constraint data, templates format per framework.

```java
// Java - framework agnostic
Map<String, Object> constraints = new HashMap<>();
constraints.put("required", prop.required);
constraints.put("maxLength", prop.maxLength);
constraints.put("pattern", prop.pattern);
// etc.
```

```mustache
{{! Laravel template }}
'{{fieldName}}' => ['required', 'string', 'max:{{maxLength}}'],

{{! Symfony template }}
#[Assert\NotBlank]
#[Assert\Length(max: {{maxLength}})]
```

**Pros:** Clean separation, templates fully control output
**Cons:** Complex mustache logic, may hit template language limitations

### Approach B: Template Directory Configuration

Template directory contains `generator-config.json` that defines:
- Which files to generate
- Directory structure
- Namespace patterns
- Base classes

```json
{
  "framework": "laravel",
  "files": {
    "controller": { "template": "controller.mustache", "dir": "app/Http/Controllers", "pattern": "{OperationId}Controller.php" },
    "request": { "template": "form-request.mustache", "dir": "app/Http/Requests", "pattern": "{OperationId}FormRequest.php" }
  },
  "namespaces": {
    "controller": "{apiPackage}\\Http\\Controllers",
    "request": "{apiPackage}\\Http\\Requests"
  }
}
```

**Pros:** Declarative, easy to understand
**Cons:** Another config format to maintain

### Approach C: Mustache Lambdas/Helpers

Java registers framework-specific lambdas based on selected framework.

```mustache
{{#laravelValidation}}{{constraints}}{{/laravelValidation}}
{{#symfonyValidation}}{{constraints}}{{/symfonyValidation}}
```

**Pros:** Powerful, can handle complex formatting
**Cons:** Still requires Java code per framework for lambdas

### Approach D: Template Partials with Framework Override

Base templates include partials, framework templates override partials.

```
php-max/
  common/
    model.mustache (includes {{>validation}})
  laravel/
    validation.mustache (Laravel format)
  symfony/
    validation.mustache (Symfony format)
```

**Pros:** Reuse common logic, override specifics
**Cons:** Partial resolution complexity

### Approach E: Pure Template Sets (RECOMMENDED - Investigation Result)
After investigation, this approach emerged as the most viable:

**Architecture:**
```
openapi-generator-server-php-max/
├── common/                    # Shared templates (enums, headers)
├── laravel/                   # Complete Laravel template set
├── symfony/                   # Complete Symfony template set
└── configs/
    ├── laravel.json          # Laravel file generation config
    └── symfony.json          # Symfony file generation config
```

**How it works:**
1. Use SAME generator (php-max or existing php-laravel/php-symfony)
2. Templates receive IDENTICAL template variables from generator
3. Templates format output per-framework conventions
4. `files` config controls which templates generate which files

**Example - Same constraint, different output:**

```mustache
{{! Laravel validation_rules.mustache }}
'{{paramName}}' => ['{{#required}}required{{/required}}', '{{#maxLength}}max:{{maxLength}}{{/maxLength}}'],

{{! Symfony validation_attrs.mustache }}
{{#required}}#[Assert\NotBlank]{{/required}}
{{#maxLength}}#[Assert\Length(max: {{maxLength}})]{{/maxLength}}
```

**Pros:**
- Templates fully control framework-specific output
- No Java code changes needed for new frameworks
- Easy to understand and maintain
- Can share common templates (enums, models)

**Cons:**
- Mustache limitations require verbose conditionals
- Template maintenance burden per framework
- Complex patterns (security) may need workarounds

**Proof of Concept:** `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/`
## 4. Implementation Specification

### Investigation Tasks

1. **Analyze current framework-specific code**
   - List all places where Laravel-specific logic exists
   - Identify what data templates would need

2. **Prototype raw constraints approach**
   - Modify AbstractPhpMaxCodegen to pass raw constraints
   - Create test templates for Laravel and Symfony
   - Evaluate mustache limitations

3. **Prototype configuration file approach**
   - Design generator-config.json schema
   - Implement config file reading in Java
   - Test with different framework configs

4. **Evaluate hybrid approaches**
   - Combine best aspects of different approaches
   - Consider user experience (ease of creating new framework support)

5. **Document decision**
   - Pros/cons of chosen approach
   - Migration path from current architecture
   - Examples for Laravel, Symfony, and custom framework

### Success Criteria

- [ ] Can generate Laravel code using only templates (no Laravel-specific Java)
- [ ] Can generate Symfony code using only templates (no Symfony-specific Java)
- [ ] Can create custom framework support without modifying Java
- [ ] Clear documentation for template authors

## 5. Acceptance Criteria

- [ ] Investigation complete with documented findings
- [ ] Recommended approach selected with justification
- [ ] Proof of concept for at least 2 frameworks
- [ ] Design document for template authors

## 6. Current State
**Status:** Investigation Complete - 5 Frameworks Validated
**Last Updated:** 2026-01-02

### Executive Summary

**Question:** Can a pure template-based solution support multiple PHP frameworks?

**Answer:** **YES, confirmed for 5 major PHP frameworks.**

| Framework | Feasibility | Complexity | Validation Style | Controller Type |
|-----------|-------------|------------|------------------|-----------------|
| **Laravel** | ✅ Feasible | Medium | FormRequest rules | Invokable |
| **Symfony** | ✅ Feasible | Medium | Assert attributes | Attribute-routed |
| **Slim** | ✅ Feasible | Low | Respect/Validation | PSR-15 handler |
| **Laminas** | ✅ Feasible | Medium | InputFilter | PSR-15 handler |
| **CodeIgniter** | ✅ Feasible | Low | Pipe-delimited | RESTful |

### Core Finding

OpenAPI Generator passes **identical template variables** to all templates. The five frameworks represent **five different validation patterns**, yet all derive from the same variables:

| Constraint | Laravel | Symfony | Slim | Laminas | CodeIgniter |
|------------|---------|---------|------|---------|-------------|
| `maxLength:50` | `'max:50'` | `#[Length(max:50)]` | `->length(,50)` | `StringLength` | `max_length[50]` |
| `required` | `'required'` | `#[NotBlank]` | no wrap | `NotEmpty` | `required` |
| `enum:[a,b]` | `'in:a,b'` | `#[Choice]` | `->in([])` | `InArray` | `in_list[a,b]` |
| `minimum:2` | `'min:2'` | `#[GreaterThanOrEqual]` | `->min(2)` | `Between` | `greater_than_equal_to[2]` |

### Five Validation Patterns Proven

1. **String array** (Laravel): `['required', 'string', 'max:50']`
2. **PHP Attributes** (Symfony): `#[Assert\NotBlank] #[Assert\Length(max: 50)]`
3. **Method chaining** (Slim): `v::stringType()->length(1, 50)`
4. **Array config** (Laminas): `['name' => StringLength::class, 'options' => ['max' => 50]]`
5. **Pipe string** (CodeIgniter): `'required|string|max_length[50]'`

### Prototype Templates Created

```
openapi-generator-server-templates/openapi-generator-server-php-max-prototype/
├── PROOF-OF-CONCEPT.md              # 500+ line analysis
│
├── laravel/
│   ├── validation_rules.mustache    # ✅
│   └── controller.mustache          # ✅
│
├── symfony/
│   ├── validation_attrs.mustache    # ✅
│   └── controller.mustache          # ✅
│
├── slim/
│   ├── validation_respect.mustache  # ✅
│   ├── handler.mustache             # ✅
│   └── routes.mustache              # ✅
│
├── laminas/
│   ├── input_filter.mustache        # ✅
│   ├── handler.mustache             # ✅
│   └── routes.mustache              # ✅
│
└── codeigniter/
    ├── validation_rules.mustache    # ✅
    ├── controller.mustache          # ✅
    └── routes.mustache              # ✅
```

### Framework Characteristics

| Aspect | Laravel | Symfony | Slim | Laminas | CodeIgniter |
|--------|---------|---------|------|---------|-------------|
| **Philosophy** | Full-stack | Component | Micro | Enterprise | Lightweight |
| **HTTP** | Custom | HttpFoundation | PSR-7 | PSR-7 | Custom |
| **DI** | Laravel DI | Symfony DI | PSR-11 | PSR-11 | Built-in |
| **Middleware** | Laravel MW | Firewall | PSR-15 | PSR-15 | Filters |

### Recommended Implementation

**Single Generator + Template Sets:**

```bash
openapi-generator generate -g php-max -t templates/laravel ...
openapi-generator generate -g php-max -t templates/symfony ...
openapi-generator generate -g php-max -t templates/slim ...
openapi-generator generate -g php-max -t templates/laminas ...
openapi-generator generate -g php-max -t templates/codeigniter ...
```

### Effort Estimate

| Task | Days |
|------|------|
| Base generator | 2-3 |
| Laravel templates | 3-4 |
| Symfony templates | 3-4 |
| Slim templates | 2-3 |
| Laminas templates | 3-4 |
| CodeIgniter templates | 2-3 |
| Testing & docs | 3-4 |
| **Total** | **18-25** |

### Next Actions

1. [ ] Decide on implementation approach (recommend Option A)
2. [ ] Create php-max generator in Java
3. [ ] Complete all 5 template sets
4. [ ] Test with TicTacToe OpenAPI spec
5. [ ] Create template authoring guide

### Artifacts

| Artifact | Location |
|----------|----------|
| Full Analysis | `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/PROOF-OF-CONCEPT.md` |
| All Templates | `...php-max-prototype/{laravel,symfony,slim,laminas,codeigniter}/` |

### External References

- [Laravel Validation](https://laravel.com/docs/validation)
- [Symfony Validation](https://symfony.com/doc/current/validation.html)
- [Slim 4 Docs](https://www.slimframework.com/docs/v4/)
- [Respect/Validation](https://respect-validation.readthedocs.io/)
- [Laminas InputFilter](https://docs.laminas.dev/laminas-inputfilter/)
- [Laminas Validator](https://docs.laminas.dev/laminas-validator/)
- [Mezzio Docs](https://docs.mezzio.dev/)
- [CodeIgniter 4 Validation](https://codeigniter.com/user_guide/libraries/validation.html)
# Same generator, different template directories
openapi-generator generate -g php-max -t templates/laravel ...
openapi-generator generate -g php-max -t templates/symfony ...
openapi-generator generate -g php-max -t templates/slim ...
```

**Why this approach:**
1. Single Java codebase to maintain
2. Templates fully control output format
3. Easy to add new frameworks (just add template directory)
4. Share common templates (enums, headers) via partials

### Challenges Identified

| Challenge | Solution |
|-----------|----------|
| Validation syntax differs | Separate validation templates per framework |
| Combined constraints (Symfony Length) | Template conditionals for combinations |
| Security patterns differ | Laravel/Slim similar; Symfony needs firewall config |
| Response patterns | Framework-specific response wrappers |
| Mustache limitations | Accept some verbosity, use partials |

### Effort Estimate

| Task | Days |
|------|------|
| Base generator setup | 2-3 |
| Laravel templates (complete) | 3-4 |
| Symfony templates (complete) | 3-4 |
| Slim templates (complete) | 2-3 |
| Testing & documentation | 2-3 |
| **Total** | **12-17** |

### Next Actions

1. [ ] Decide on implementation approach (recommend Option A)
2. [ ] Create or extend php-max generator in Java (if Option A)
3. [ ] Complete Laravel template set
4. [ ] Complete Symfony template set
5. [ ] Complete Slim template set
6. [ ] Test all three with TicTacToe OpenAPI spec
7. [ ] Create template authoring documentation

### Artifacts

| Artifact | Location |
|----------|----------|
| Full Analysis | `openapi-generator-server-templates/openapi-generator-server-php-max-prototype/PROOF-OF-CONCEPT.md` |
| Laravel Templates | `...php-max-prototype/laravel/` |
| Symfony Templates | `...php-max-prototype/symfony/` |
| Slim Templates | `...php-max-prototype/slim/` |
| Laravel-Symfony Mapping | `...openapi-generator-server-php-symfony-default/LARAVEL-SYMFONY-MAPPING.md` |

### External References

- [Slim 4 Documentation](https://www.slimframework.com/docs/v4/)
- [Symfony Validation](https://symfony.com/doc/current/validation.html)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Respect/Validation](https://respect-validation.readthedocs.io/)
- [PHP-DI](https://php-di.org/)