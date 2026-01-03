---
code: GENDE-049
status: Proposed
dateCreated: 2026-01-03T18:00:00.000Z
type: Bug Fix
priority: Medium
relatedTickets: GENDE-036,GENDE-037,GENDE-038
---

# Fix missing baseType variable in php-max Symfony resource template

## 1. Description

The `resource.mustache` template in php-max Symfony templates references a `{{baseType}}` variable that is not provided by the generator, causing template rendering errors or empty output.

## 2. Rationale

During GENDE-036/037/038 work, the response template was copied to resource.mustache to satisfy the generator's expected template name. However, the template content uses variables that may not be available in the resource generation context.

## 3. Solution Analysis

**Investigation Needed:**
1. Determine what variables are available during resource template processing
2. Check if `baseType` should be replaced with another variable like `classname` or `returnType`
3. Review the template loop context for resource generation vs response generation

## 4. Implementation Specification

- **Template:** `openapi-generator-generators/php-max/src/main/resources/symfony-max/resource.mustache`
- **Copied from:** `response.mustache` (which was copied to `resource.mustache` because generator expected different filename)

## 5. Acceptance Criteria

- [ ] Resource template renders without errors
- [ ] Generated resource classes are valid PHP
- [ ] Resource classes serve their intended purpose in the Symfony architecture
