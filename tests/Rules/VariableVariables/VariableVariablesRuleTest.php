<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class VariableVariablesRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariableVariablesRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/variables.php'], [
			[
				'Variable variables are not allowed.',
				8,
			],
			[
				'Variable variables are not allowed.',
				13,
			],
		]);
	}

}
