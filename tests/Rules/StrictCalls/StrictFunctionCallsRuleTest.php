<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use const PHP_VERSION_ID;

/**
 * @extends RuleTestCase<StrictFunctionCallsRule>
 */
class StrictFunctionCallsRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new StrictFunctionCallsRule($this->createReflectionProvider());
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/strict-calls.php'], [
			[
				'Call to function in_array() requires parameter #3 to be set.',
				5,
			],
			[
				'Call to function in_array() requires parameter #3 to be true.',
				7,
			],
			[
				'Call to function in_array() requires parameter #3 to be set.',
				8,
			],
			[
				'Call to function array_search() requires parameter #3 to be set.',
				10,
			],
			[
				'Call to function array_search() requires parameter #3 to be true.',
				12,
			],
			[
				'Call to function array_search() requires parameter #3 to be set.',
				13,
			],
			[
				'Call to function base64_decode() requires parameter #2 to be set.',
				15,
			],
			[
				'Call to function base64_decode() requires parameter #2 to be true.',
				17,
			],
			[
				'Call to function base64_decode() requires parameter #2 to be set.',
				18,
			],
			[
				'Call to function array_keys() requires parameter #3 to be set.',
				20,
			],
			[
				'Call to function array_keys() requires parameter #3 to be true.',
				22,
			],
			[
				'Call to function array_keys() requires parameter #3 to be set.',
				23,
			],
			[
				'Call to function array_keys() requires parameter #3 to be true.',
				31,
			],
		]);
	}

	public function testFix(): void
	{
		$this->fix(
			__DIR__ . '/data/strict-function-calls-fixable.php',
			__DIR__ . '/data/strict-function-calls-fixable.php.fixed',
		);
	}

	public function testFixNamedArguments(): void
	{
		if (PHP_VERSION_ID < 80000) {
			self::markTestSkipped('Test requires PHP 8.0.');
		}

		$this->fix(
			__DIR__ . '/data/strict-function-calls-named-arguments.php',
			__DIR__ . '/data/strict-function-calls-named-arguments.php.fixed',
		);
	}

	public function testFixPositionalBeforeNamed(): void
	{
		$this->fix(
			__DIR__ . '/data/strict-function-calls-positional-before-named.php',
			__DIR__ . '/data/strict-function-calls-positional-before-named.php.fixed',
		);
	}


	public function testBug231(): void
	{
		if (PHP_VERSION_ID < 80100) {
			self::markTestSkipped('Test requires PHP 8.1.');
		}
		$this->analyse([__DIR__ . '/data/bug-231.php'], []);
	}

}
