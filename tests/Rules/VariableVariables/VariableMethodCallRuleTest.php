<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<VariableMethodCallRule>
 */
class VariableMethodCallRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariableMethodCallRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/methods.php'], [
			[
				'Variable method call on stdClass.',
				7,
			],
		]);
	}

}
