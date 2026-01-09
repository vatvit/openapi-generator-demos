---
code: GENDE-124
status: Implemented
dateCreated: 2026-01-07T16:47:10.280Z
type: Documentation
priority: Medium
phaseEpic: Documentation
relatedTickets: GENDE-088,GENDE-107,GENDE-115,GENDE-123
---

# Create documentation for new generator and features

## 1. Description

Create comprehensive documentation for the new generator and all its features.

## 2. Rationale

Good documentation is essential for:
- Users to understand how to use the generator
- Developers to extend or contribute
- Maintainability long-term

## 3. Solution Analysis

### Documentation Locations

| Document | Location | Purpose |
|----------|----------|----------|
| Generator README | `openapi-generator-generators/{name}/README.md` | Usage, options, examples |
| Laravel Templates README | Embedded in generator | Template customization |
| Symfony Templates README | `openapi-generator-server-templates/{name}-symfony/README.md` | External template usage |
| Slim Templates README | `openapi-generator-server-templates/{name}-slim/README.md` | External template usage |
| Architecture Doc | `docs/ARCHITECTURE.md` or in generator | Design decisions |
| Integration Guide | Per integration project | How to integrate generated libs |

### Documentation Content

#### Generator README
- Installation
- Basic usage
- Configuration options
- Per-operation generation explanation
- Template customization
- Examples with both specs

#### Template READMEs (External)
- How to use with `-t` flag
- Template structure
- Customization points
- Framework-specific patterns

#### Architecture Documentation
- Design decisions
- Component boundaries
- Extension points
- Comparison with php-max PoC

## 4. Implementation Specification

### Files to Create
```
openapi-generator-generators/{name}/
├── README.md                    # Main generator docs
└── docs/
    └── ARCHITECTURE.md          # Design documentation

openapi-generator-server-templates/{name}-symfony/
└── README.md                    # Symfony template docs

openapi-generator-server-templates/{name}-slim/
└── README.md                    # Slim template docs

projects/laravel-api--{name}--integration-tests/
└── README.md                    # Laravel integration guide

projects/symfony-api--{name}--integration-tests/
└── README.md                    # Symfony integration guide

projects/slim-api--{name}--integration-tests/
└── README.md                    # Slim integration guide
```

## 5. Acceptance Criteria

- [ ] Generator README with usage examples
- [ ] Symfony templates README
- [ ] Slim templates README
- [ ] Architecture documentation
- [ ] Integration guides for each framework
- [ ] All code examples tested and working