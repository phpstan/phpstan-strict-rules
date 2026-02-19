# CLAUDE.md

## Project Overview

**phpstan/phpstan-strict-rules** is a PHPStan extension that provides extra strict and opinionated rules for PHP static analysis. While PHPStan focuses on finding bugs, this package enforces strictly and strongly typed code with no loose casting, targeting developers who want additional safety through defensive programming.

The package is installed via Composer (`phpstan/phpstan-strict-rules`) and integrates with PHPStan through the `rules.neon` configuration file.

## PHP Version Support

This repository supports **PHP 7.4+** (unlike phpstan-src which is PHP 8.1+ with PHAR downgrade). The `composer.json` sets `"php": "^7.4 || ^8.0"` and the platform is pinned to PHP 7.4.6 for dependency resolution.

**Do not use PHP 8.0+ syntax** (named arguments, match expressions, union type hints in signatures, etc.) in the source code. Property declarations with types (e.g., `private Type $prop;`) are allowed as they are PHP 7.4 syntax.

## Repository Structure

```
├── src/Rules/                  # Rule implementations (PSR-4: PHPStan\)
│   ├── BooleansInConditions/   # Rules requiring booleans in conditions
│   ├── Cast/                   # Useless cast detection
│   ├── Classes/                # Parent constructor call requirements
│   ├── DisallowedConstructs/   # Bans on empty(), loose comparison, backtick, etc.
│   ├── ForLoop/                # Variable overwrite detection in for loops
│   ├── ForeachLoop/            # Variable overwrite detection in foreach loops
│   ├── Functions/              # Strict array_filter, closure $this usage
│   ├── Methods/                # Illegal constructor calls, method name casing
│   ├── Operators/              # Numeric operand enforcement in arithmetic
│   ├── StrictCalls/            # Strict function calls, static method enforcement
│   ├── SwitchConditions/       # Type matching in switch/case
│   └── VariableVariables/      # Disallow variable variables
├── tests/Rules/                # Tests mirroring src/ structure
│   └── */data/                 # PHP test fixture files
├── tests/Levels/               # Integration tests for PHPStan levels
├── rules.neon                  # Main extension config (parameters, services, conditional tags)
├── phpstan.neon                # Self-analysis config (used for analysing this repo)
├── phpunit.xml                 # PHPUnit configuration
├── Makefile                    # Build commands
└── composer.json               # Package definition
```

## How Rules Work

Each rule implements `PHPStan\Rules\Rule<TNodeType>`:

1. **`getNodeType(): string`** — Returns the PHP-Parser AST node class this rule inspects.
2. **`processNode(Node $node, Scope $scope): array`** — Analyses the node and returns an array of errors (empty array = no errors).

Errors are built with `RuleErrorBuilder::message('...')->identifier('error.id')->build()`.

Helper classes (`BooleanRuleHelper`, `OperatorRuleHelper`) contain shared validation logic and are injected via constructor.

Rules are registered as services in `rules.neon` and toggled via `conditionalTags` tied to `strictRules.*` parameters.

## Configuration System

`rules.neon` serves two purposes:

1. **Sets stricter PHPStan defaults** (lines 1-16): Parameters like `checkDynamicProperties`, `reportMaybesInMethodSignatures`, `checkFunctionNameCase`, etc. These are always active when the extension is installed.
2. **Registers toggleable custom rules** (lines 17+): Each rule can be individually enabled/disabled through `strictRules.*` parameters using `conditionalTags`.

The `allRules` parameter (default: `true`) controls all rules at once. Individual parameters override it.

## Development Commands

All commands are in the `Makefile`:

```bash
make check          # Run all checks (lint + cs + tests + phpstan)
make lint           # PHP syntax check via parallel-lint
make cs             # Coding standards check (requires build-cs, see cs-install)
make cs-install     # Clone and install phpstan/build-cs
make cs-fix         # Auto-fix coding standard violations
make tests          # Run PHPUnit tests
make phpstan        # Run PHPStan self-analysis at level 8
```

To set up the project:
```bash
composer install
```

For coding standards (separate tooling):
```bash
make cs-install
make cs
```

## Testing

Tests use PHPUnit 9.6 and PHPStan's `RuleTestCase` base class.

### Test structure

- Each rule has a corresponding `*Test.php` in `tests/Rules/` mirroring the `src/Rules/` directory structure.
- Test data files (PHP fixtures) live in `tests/Rules/*/data/`.
- Integration-level tests are in `tests/Levels/`.

### Writing a test

```php
/**
 * @extends RuleTestCase<YourRule>
 */
class YourRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new YourRule(/* dependencies */);
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/data/fixture.php'], [
            [
                'Expected error message text.',
                42, // line number
            ],
        ]);
    }
}
```

For rules with dependencies, use `self::getContainer()->getByType(ClassName::class)` to get services from PHPStan's DI container.

Some tests conditionally check based on `PHP_VERSION_ID` for version-specific behavior.

### Running tests

```bash
make tests          # Run all tests
php vendor/bin/phpunit                             # Run all tests directly
php vendor/bin/phpunit tests/Rules/Cast/           # Run tests in a directory
php vendor/bin/phpunit --filter UselessCastRuleTest # Run a specific test
```

## CI Pipeline

GitHub Actions (`.github/workflows/build.yml`) runs on PRs and pushes to `2.0.x`:

- **Lint**: PHP syntax check on PHP 7.4–8.4
- **Coding Standard**: phpcs via phpstan/build-cs (2.x branch)
- **Tests**: PHPUnit on PHP 7.4–8.4, both lowest and highest dependencies
- **Static Analysis**: PHPStan at level 8 on PHP 7.4–8.4, both lowest and highest dependencies

The default branch is `2.0.x`.

## Coding Standards

- Uses phpstan/build-cs (2.x branch) with phpcs for coding standards.
- **Tabs for indentation** in PHP, XML, and Neon files (see `.editorconfig`).
- Spaces for YAML files.
- `declare(strict_types = 1)` at the top of every PHP file.
- PSR-4 autoloading: `PHPStan\` namespace maps to `src/`.
- Import functions explicitly (`use function sprintf;`), not via `\sprintf()`.
