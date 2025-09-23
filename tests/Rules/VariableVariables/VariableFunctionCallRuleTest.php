<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<VariableFunctionCallRule>
 */
class VariableFunctionCallRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariableFunctionCallRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/functions.php'], [
			[
				'Variable function call.',
				6,
			],
			[
				'Variable function call.',
				14,
			],
			[
				'Variable function call.',
				16,
			],
			[
				'Variable function call.',
				18,
			],
		]);
	}

}
