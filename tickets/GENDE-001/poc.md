# Proof of Concept: Custom OpenAPI Generator Implementation

**CR**: GENDE-001
**Date Started**: 2025-12-28
**Status**: In Progress

## Investigation Goals

Validate technical uncertainties before architecture design through hands-on experimentation.

### Core Questions

1. **How to create custom generator from scratch**
   - What are the required files and directory structure?
   - What is the step-by-step creation process?
   - How does OpenAPI Generator discover and load custom generators?
   - What's the minimal viable generator?

2. **Mustache workarounds for complex logic**
   - How to handle complex transformations (e.g., camelCase → snake_case)?
   - How to implement conditional logic beyond simple {{#variable}}?
   - How to handle loops with complex data structures?
   - What are Mustache's hard limitations and workarounds?

## Hypotheses

**H1: Custom Generator Creation**
- Hypothesis: Custom generators require Java CodegenConfig class + mustache templates
- Success Criteria: Create minimal working generator that produces "Hello World" output
- Failure Criteria: Cannot create generator without forking core OpenAPI Generator

**H2: Mustache Complexity Workarounds**
- Hypothesis: Complex logic must live in CodegenConfig (Java), not templates
- Success Criteria: Implement 3 complex transformations (naming conventions, type mappings, conditional structure)
- Failure Criteria: Templates require extensive workarounds making them unmaintainable

## Investigation Plan

### Phase 1: Generator Creation (2-3 hours)

**Steps**:
1. Study existing generator structure (php-laravel as reference)
2. Create minimal custom generator skeleton
3. Register generator with OpenAPI Generator
4. Generate simple output from test spec
5. Document the process step-by-step

**Deliverables**:
- Working minimal generator in `poc/minimal-generator/`
- Step-by-step creation guide
- Required files inventory

### Phase 2: Mustache Complexity Testing (2-3 hours)

**Test Cases**:
1. **Naming Transformation**: Convert OpenAPI naming to framework conventions
2. **Conditional Structure**: Generate different code based on OpenAPI schema properties
3. **Complex Loops**: Iterate nested OpenAPI structures with transformations
4. **Type Mapping**: Map OpenAPI types to framework-specific types

**Deliverables**:
- Test templates in `poc/template-tests/`
- CodegenConfig helpers for each test case
- Documented patterns and workarounds

### Phase 3: Integration Validation (1-2 hours)

**Validation**:
1. Generate code from real OpenAPI spec (use existing spec from project)
2. Compare output approach to `laravel-max/` reference quality
3. Identify gaps between "what we can generate" vs "what we want to generate"
4. Document architectural constraints discovered

**Deliverables**:
- Generated sample in `poc/generated-sample/`
- Gap analysis document
- Constraint list for architecture

## Findings

### Generator Creation

**Status**: Research phase complete

**What We Learned**:

#### Official Creation Process

OpenAPI Generator provides two methods for creating custom generators:

**Method 1: `new.sh` Script** (Requires source code)
- Location: Root of OpenAPI Generator repository
- Command: `./new.sh -n <generator-name> [-c|-s|-d|-H|-f] [-t]`
- Options:
  - `-n`: Generator name (kebab-cased, required)
  - `-c`: Client generator
  - `-s`: Server generator
  - `-d`: Documentation generator
  - `-H`: Schema generator
  - `-f`: Config generator
  - `-t`: Include test files

**Method 2: `meta` Command** (Via CLI/Docker)
- Command: `java -jar openapi-generator-cli.jar meta -o out/generators/my-codegen -n my-codegen -p com.my.company.codegen`
- Creates generator skeleton without full source code

#### Required Files (Auto-Generated)

```
modules/openapi-generator/src/main/java/org/openapitools/codegen/languages/
  └── MyGeneratorCodegen.java           # Java configuration class

modules/openapi-generator/src/main/resources/my-generator/
  ├── README.mustache                   # Supporting file (once)
  ├── model.mustache                    # Template per model
  └── api.mustache                      # Template per API

META-INF/services/org.openapitools.codegen.CodegenConfig
  # SPI registration (automatic)

bin/configs/
  └── my-generator-petstore-new.yaml    # Test configuration
```

#### Java CodegenConfig Class Responsibilities

The `*Codegen.java` class configures:

| Property | Purpose | Example |
|----------|---------|---------|
| `outputFolder` | Default output location | `"generated-code/my-generator"` |
| `modelTemplateFiles` | Model template + extension | `.put("model.mustache", ".md")` |
| `apiTemplateFiles` | API template + extension | `.put("api.mustache", ".md")` |
| `embeddedTemplateDir` | Built-in templates directory | `"my-generator"` |
| `templateDir` | User-overridable templates | Same as `embeddedTemplateDir` |
| `apiPackage` | API output directory | `File.separator + "Apis"` |
| `modelPackage` | Model output directory | `File.separator + "Models"` |
| `supportingFiles` | Single files (READMEs, etc.) | `new SupportingFile("README.mustache", "", "README.md")` |

#### Template Discovery Order

1. Check `embeddedTemplateDir` (built-in templates)
2. Check user's `templateDir` (custom templates via `-t` flag)
3. Check library subdirectories

#### Build and Test Process

**Quick compile** (skip tests):
```bash
mvn clean package -DskipTests
```

**Generate sample output:**
```bash
./bin/generate-samples.sh bin/configs/my-generator-petstore-new.yaml
```

**Using Docker** (our current setup):
```bash
docker run --rm -v $$(pwd):/local openapitools/openapi-generator-cli:latest generate \
  -g my-generator \
  -i /local/spec.yaml \
  -o /local/output
```

#### Critical Discovery: **Docker vs Source Build**

**Challenge**: The user's current workflow uses Docker (`openapitools/openapi-generator-cli`), but creating custom generators typically requires building from source.

**Options for Custom Generators**:
1. **Build from source** - Clone OpenAPI Generator repo, use `new.sh`, compile Java
2. **Use meta command via Docker** - May work, need to verify
3. **Create external generator** - Package as separate JAR, add to classpath
4. **Hybrid approach** - Develop generator in separate project, build JAR, use with Docker

**Decisions for Architecture**:
- ✅ **VALIDATED**: Custom generators CAN be used with Docker without full source build
- ✅ **CONFIRMED**: Generators packaged as separate JARs work perfectly
- ✅ **PROVEN**: Build/distribution process is Docker-only (Maven + eclipse-temurin images)

#### End-to-End Workflow (100% Docker-Only)

**Step 1: Create Generator Skeleton**
```bash
docker run --rm -v $(pwd):/local openapitools/openapi-generator-cli:latest meta \
  -o /local/tickets/GENDE-001/poc/minimal-generator \
  -n minimal-test \
  -p com.test.codegen
```

**Output**: Complete Java project with:
- `src/main/java/com/test/codegen/MinimalTestGenerator.java` (Java config class)
- `src/main/resources/minimal-test/*.mustache` (templates)
- `pom.xml` (Maven build file)
- `README.md` (usage instructions)

**Step 2: Build Generator JAR**
```bash
docker run --rm -v $(pwd):/workspace -w /workspace maven:3-openjdk-11 \
  mvn clean package -DskipTests
```

**Output**:
- `target/minimal-test-openapi-generator-1.0.0.jar` (23KB)
- Ready to use with OpenAPI Generator CLI

**Step 3: Use Generator**
```bash
# Download OpenAPI Generator CLI JAR
curl -L https://repo1.maven.org/maven2/org/openapitools/openapi-generator-cli/7.10.0/openapi-generator-cli-7.10.0.jar \
  -o openapi-generator-cli-7.10.0.jar

# Generate code
docker run --rm -v $(pwd):/local -w /local eclipse-temurin:11-jre \
  java -cp /local/openapi-generator-cli-7.10.0.jar:/local/path/to/your-generator.jar \
  org.openapitools.codegen.OpenAPIGenerator generate \
  -g minimal-test \
  -i /local/spec.yaml \
  -o /local/output
```

**Output**: Generated code from OpenAPI spec!
- Models: Error.sample, NewPet.sample, Pet.sample
- APIs: 11 API files (.sample extension)
- Supporting files: myFile.sample

#### Critical Discoveries

**Discovery #1: SNAPSHOT Version Issue**
- `meta` command generates pom.xml with `7.18.0-SNAPSHOT` version
- SNAPSHOT versions not in Maven Central
- **Solution**: Change to released version (7.10.0) in pom.xml before building
- **For Architecture**: Generator build process must handle version alignment

**Discovery #2: Docker Image Requirements**
- `maven:3-openjdk-11` for building (Maven + Java compiler)
- `eclipse-temurin:11-jre` for running (Java runtime only)
- **For Architecture**: Document required Docker images for dev/production

**Discovery #3: JAR Distribution**
- Custom generator JAR is small (~23KB)
- Can be versioned and distributed independently
- Works with any OpenAPI Generator CLI version (same major.minor)
- **For Architecture**: Generator JARs can be published to Maven Central or private registry

**Discovery #4: No Source Code Needed**
- Don't need to clone OpenAPI Generator repo
- Don't need to build OpenAPI Generator from source
- Don't need local Java/Maven installation
- **For Architecture**: Significantly simplifies developer onboarding

### Template Engine Capabilities

**Status**: Phase 2 - Ready to start

**What We Learned**:
- Default templates use simple Mustache syntax (`# This is a sample model mustache template.`)
- Templates have access to model/API data structures
- File extension controlled by Java CodegenConfig (`modelTemplateFiles.put("model.mustache", ".sample")`)
- **Next**: Test complex transformations, conditionals, loops

**Decisions for Architecture**:
- TBD (Phase 2)

### Architectural Constraints Discovered

**Status**: Not started

**Constraints**:
- TBD

## Recommendations for Architecture

**Status**: Phase 1 complete - Generator creation validated

Based on PoC findings, recommendations for `/mdt:architecture`:

### 1. Generator Development Workflow

**Recommended Approach**: Docker-Only Development

```
Developer Workflow:
1. Run `meta` command via Docker → Generator skeleton
2. Edit Java CodegenConfig class (customize logic)
3. Edit Mustache templates (customize output)
4. Run Maven via Docker → Build JAR
5. Test with real OpenAPI spec → Iterate
6. Publish JAR to registry → Distribute
```

**Why This Works:**
- No local Java/Maven required (low barrier to entry)
- Reproducible builds (Docker containers)
- Easy CI/CD integration
- Fast iteration cycle (edit → build → test)

### 2. Generator Distribution Strategy

**Option A: Maven Central (Recommended for open-source)**
- Publish generator JARs to Maven Central
- Users: `curl` JAR + use with Docker
- Pros: Standard Java ecosystem, versioning, dependency management
- Cons: Requires Maven Central account, release process

**Option B: GitHub Releases**
- Attach JAR files to GitHub releases
- Users: Download from releases page
- Pros: Simple, no external accounts needed
- Cons: No dependency resolution, manual downloads

**Option C: Private Maven Repository (Recommended for enterprise)**
- Host on Nexus/Artifactory
- Pros: Private, controlled access, dependency management
- Cons: Infrastructure requirement

### 3. Version Management

**Critical**: Generator version must align with OpenAPI Generator CLI version

```toml
# .generator-config.toml (proposed)
[generator]
name = "laravel-max"
version = "1.0.0"
openapi_generator_version = "7.10.0"  # Must match CLI version

[build]
docker_maven_image = "maven:3-openjdk-11"
docker_java_image = "eclipse-temurin:11-jre"
```

### 4. Multi-Framework Support

**Approach**: Separate generators per framework

```
generators/
├── laravel-generator/      # -g laravel-max
├── symfony-generator/      # -g symfony-max
└── express-generator/      # -g express-max
```

**Why Not One Generator:**
- Framework-specific logic in Java CodegenConfig
- Different template sets per framework
- Independent versioning and releases
- Clearer separation of concerns

### 5. Template Organization

**Recommended Structure:**
```
src/main/resources/{generator-name}/
├── common/                 # Shared partials
│   ├── header.mustache
│   ├── validation.mustache
│   └── error-handling.mustache
├── laravel/                # Framework-specific
│   ├── controller.mustache
│   ├── model.mustache
│   ├── route.mustache
│   └── middleware.mustache
└── supporting/
    ├── README.mustache
    └── composer.json.mustache
```

### 6. Testing Strategy

**Phase 2 Will Validate:**
- Mustache template complexity limits
- CodegenConfig transformation capabilities
- Multi-file generation patterns
- Framework-specific customizations

**After Phase 2:**
- Document template best practices
- Create template testing framework
- Define Mustache → Java boundary

### 7. Developer Experience Improvements

**Proposed Tooling:**
```bash
# Wrapper script: bin/generate-dev.sh
#!/bin/bash
# Auto-handles: JAR download, Docker setup, generation, cleanup
./bin/generate-dev.sh -g laravel-max -i spec.yaml -o output/
```

**Benefits:**
- Hides Docker complexity from users
- Automatic JAR caching
- Version management
- Error handling and logging

### 8. Next Steps (Phase 2)

**Immediate:**
1. Test Mustache template capabilities (Phase 2)
2. Identify Java vs Template responsibilities
3. Document complex transformation patterns
4. Validate multi-file generation

**After PoC:**
1. Design generator API/interface
2. Create framework-agnostic base class
3. Build template library (common patterns)
4. Write generator development guide

## Appendix

### Resources Used
- [OpenAPI Generator - Create a New Generator](https://openapi-generator.tech/docs/new-generator/)
- [OpenAPI Generator - Customization](https://openapi-generator.tech/docs/customization/)
- [OpenAPI Generator - Templating](https://openapi-generator.tech/docs/templating/)
- [Mustache Documentation](https://mustache.github.io/)
- [Maven Central - OpenAPI Generator](https://repo1.maven.org/maven2/org/openapitools/openapi-generator-cli/)

### Docker Images Used
- `openapitools/openapi-generator-cli:latest` - Generator skeleton creation (`meta` command)
- `maven:3-openjdk-11` - Building generator JAR
- `eclipse-temurin:11-jre` - Running generator to produce code

### Files Created During PoC
```
tickets/GENDE-001/poc/
├── poc.md                                          # This document
├── openapi-generator-cli-7.10.0.jar               # Downloaded CLI JAR (28.7 MB)
├── minimal-generator/                              # Generated skeleton
│   ├── pom.xml                                    # Maven build (modified: SNAPSHOT → 7.10.0)
│   ├── README.md                                  # Generated docs
│   ├── src/main/java/com/test/codegen/
│   │   └── MinimalTestGenerator.java             # Java config class
│   ├── src/main/resources/minimal-test/
│   │   ├── api.mustache                          # API template
│   │   ├── model.mustache                        # Model template
│   │   └── myFile.mustache                       # Supporting file template
│   ├── src/test/java/com/test/codegen/
│   │   └── MinimalTestGeneratorTest.java         # Generated test
│   └── target/
│       ├── minimal-test-openapi-generator-1.0.0.jar        # Built JAR (23 KB)
│       └── minimal-test-openapi-generator-1.0.0-tests.jar  # Test JAR
└── generated-sample/                               # Generated output
    ├── src/org/openapitools/
    │   ├── model/                                 # 3 models (Error, NewPet, Pet)
    │   └── api/                                   # 11 API files
    └── myFile.sample                              # Supporting file
```

### Time Tracking
- **Phase 1 (Generator Creation)**: ~3 hours
  - Research: 30 min
  - Skeleton creation: 15 min
  - Build troubleshooting: 45 min
  - End-to-end validation: 30 min
  - Documentation: 1 hour
- **Phase 2 (Mustache Testing)**: Not started
- **Phase 3 (Integration Validation)**: Not started
- **Total**: ~3 hours (Phase 1 only)
