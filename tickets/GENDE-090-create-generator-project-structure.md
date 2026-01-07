---
code: GENDE-090
status: Implemented
dateCreated: 2026-01-07T16:39:11.173Z
type: Feature Enhancement
priority: High
phaseEpic: Phase 1: Generator
relatedTickets: GENDE-088,GENDE-089
dependsOn: GENDE-089
---

# Create generator project structure

## 1. Description

Create the Maven project structure for the new generator.

## 2. Rationale

Need proper project structure before implementing generator logic.

## 3. Solution Analysis

### Project Structure
```
openapi-generator-generators/{generator-name}/
├── pom.xml
├── src/
│   ├── main/
│   │   ├── java/org/openapitools/codegen/languages/
│   │   │   └── {GeneratorName}Generator.java
│   │   └── resources/
│   │       ├── {generator-name}/  (templates)
│   │       └── META-INF/services/
│   └── test/
└── Makefile
```

## 4. Implementation Specification

### Files to Create
1. `pom.xml` with dependencies on extended core
2. Generator class skeleton
3. `META-INF/services/org.openapitools.codegen.CodegenConfig`
4. Empty template directory
5. Makefile for build commands

## 5. Acceptance Criteria
- [x] Project structure created
- [x] `mvn compile` succeeds
- [x] Generator discoverable by OpenAPI Generator CLI (via META-INF/services)