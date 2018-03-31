# Extra strict and opinionated rules for PHPStan

[![Build Status](https://travis-ci.org/phpstan/phpstan-strict-rules.svg)](https://travis-ci.org/phpstan/phpstan-strict-rules)
[![Latest Stable Version](https://poser.pugx.org/phpstan/phpstan-strict-rules/v/stable)](https://packagist.org/packages/phpstan/phpstan-strict-rules)
[![License](https://poser.pugx.org/phpstan/phpstan-strict-rules/license)](https://packagist.org/packages/phpstan/phpstan-strict-rules)

[PHPStan](https://github.com/phpstan/phpstan) focuses on finding bugs in your code. But in PHP there's a lot of leeway in how stuff can be written. This repository contains additional rules that revolve around strictly and strongly typed code with no loose casting for those who want additional safety in extremely defensive programming:

* Require booleans in `if`, `elseif`, ternary operator, after `!`, and on both sides of `&&` and `||`.
* These functions contain a `$strict` parameter for better type safety, it must be set to `true`:
  * `in_array` (3rd parameter)
  * `array_search` (3rd parameter)
  * `array_keys` (3rd parameter; only if the 2nd parameter `$search_value` is provided)
  * `base64_decode` (2nd parameter)
* Variables assigned in `while` loop condition and `for` loop initial assignment cannot be used after the loop.
* Types in `switch` condition and `case` value must match. PHP compares them loosely by default and that can lead to unexpected results.
* Statically declared methods are called statically.
* Disallow `empty()` - it's a very loose comparison (see [manual](https://secure.php.net/manual/en/function.empty.php)), it's recommended to use more strict one.
* Always true `instanceof`, type-checking `is_*` functions and strict comparisons `===`/`!==`. These checks can be turned off by setting `checkAlwaysTrueInstanceof`/`checkAlwaysTrueCheckTypeFunctionCall`/`checkAlwaysTrueStrictComparison` to false.
* Correct case for referenced and called function names.

Additional rules are coming in subsequent releases!

## Usage

To use these rules, require it in [Composer](https://getcomposer.org/):

```
composer require --dev phpstan/phpstan-strict-rules
```

And include rules.neon in your project's PHPStan config:

```
includes:
	- vendor/phpstan/phpstan-strict-rules/rules.neon
```

## Enabling rules one-by-one

If you don't want to start using all the available strict rules at once but only one or two, you can! Just don't include the whole `rules.neon` from this package in your configuration, but look at its contents and copy only the rules you want to your configuration:

```
	-
		class: PHPStan\Rules\StrictCalls\StrictFunctionCallsRule
		tags:
			- phpstan.rules.rule

	-
		class: PHPStan\Rules\SwitchConditions\MatchingTypeInSwitchCaseConditionRule
		tags:
			- phpstan.rules.rule
```
