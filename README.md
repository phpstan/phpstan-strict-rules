# Extra strict and opinionated rules for PHPStan

[![Build Status](https://travis-ci.org/phpstan/phpstan-strict-rules.svg)](https://travis-ci.org/phpstan/phpstan-strict-rules)
[![Latest Stable Version](https://poser.pugx.org/phpstan/phpstan-strict-rules/v/stable)](https://packagist.org/packages/phpstan/phpstan-strict-rules)
[![License](https://poser.pugx.org/phpstan/phpstan-strict-rules/license)](https://packagist.org/packages/phpstan/phpstan-strict-rules)

[PHPStan](https://github.com/phpstan/phpstan) focuses on finding bugs in your code. But in PHP there's a lot of leeway in how stuff can be written. This repository contains additional rules that revolve around strictly and strongly typed code with no loose casting for those who want additional safety in extremely defensive programming:

* Require booleans in `if`, `elseif`, ternary operator, after `!`, and on both sides of `&&` and `||`.
* Require numeric operands or arrays in `+` and numeric operands in `-`/`*`/`/`/`**`/`%`.
* Require numeric operand in `$var++`, `$var--`, `++$var`and `--$var`.
* These functions contain a `$strict` parameter for better type safety, it must be set to `true`:
  * `in_array` (3rd parameter)
  * `array_search` (3rd parameter)
  * `array_keys` (3rd parameter; only if the 2nd parameter `$search_value` is provided)
  * `base64_decode` (2nd parameter)
* Variables assigned in `while` loop condition and `for` loop initial assignment cannot be used after the loop.
* Variables set in foreach that's always looped thanks to non-empty arrays cannot be used after the loop.
* Types in `switch` condition and `case` value must match. PHP compares them loosely by default and that can lead to unexpected results.
* Check that statically declared methods are called statically.
* Disallow `empty()` - it's a very loose comparison (see [manual](https://php.net/empty)), it's recommended to use more strict one.
* Disallow short ternary operator (`?:`) - implies weak comparison, it's recommended to use null coalesce operator (`??`) or ternary operator with strict condition.
* Disallow variable variables (`$$foo`, `$this->$method()` etc.)
* Disallow overwriting variables with foreach key and value variables
* Always true `instanceof`, type-checking `is_*` functions and strict comparisons `===`/`!==`. These checks can be turned off by setting `checkAlwaysTrueInstanceof`/`checkAlwaysTrueCheckTypeFunctionCall`/`checkAlwaysTrueStrictComparison` to false.
* Correct case for referenced and called function names.
* Correct case for inherited and implemented method names.
* Contravariance for parameter types and covariance for return types in inherited methods (also known as Liskov substitution principle - LSP)
* Check LSP even for static methods
* Check missing typehint in anonymous function when a native one could be added
* Require calling parent constructor
* Disallow usage of backtick operator (`` $ls = `ls -la` ``)

Additional rules are coming in subsequent releases!


## Installation

To use this extension, require it in [Composer](https://getcomposer.org/):

```
composer require --dev phpstan/phpstan-strict-rules
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include rules.neon in your project's PHPStan config:

```
includes:
    - vendor/phpstan/phpstan-strict-rules/rules.neon
```
</details>


## Enabling rules one-by-one

If you don't want to start using all the available strict rules at once but only one or two, you can! Just don't include the whole `rules.neon` from this package in your configuration, but look at its contents and copy only the rules you want to your configuration under the `services` key:

```
services:
	-
		class: PHPStan\Rules\StrictCalls\StrictFunctionCallsRule
		tags:
			- phpstan.rules.rule

	-
		class: PHPStan\Rules\SwitchConditions\MatchingTypeInSwitchCaseConditionRule
		tags:
			- phpstan.rules.rule
```

*Unfortunately, you cannot use phpstan/extension-installer in this case.*
