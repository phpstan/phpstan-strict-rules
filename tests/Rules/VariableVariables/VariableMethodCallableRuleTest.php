<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<VariableMethodCallableRule>
 */
class VariableMethodCallableRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariableMethodCallableRule();
	}

	public function testRule(): void
	{
		if (PHP_VERSION_ID < 80100) {
			self::markTestSkipped('Test requires PHP 8.1.');
		}

		$this->analyse([__DIR__ . '/data/methods-callables.php'], [
			[
				'Variable method call on stdClass.',
				7,
			],
		]);
	}

}
