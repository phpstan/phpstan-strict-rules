<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class VariableStaticPropertyFetchRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariableStaticPropertyFetchRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/staticProperties.php'], [
			[
				'Variable static properties are not allowed.',
				7,
			],
			[
				'Variable static properties are not allowed.',
				8,
			],
			[
				'Variable static properties are not allowed.',
				10,
			],
			[
				'Variable static properties are not allowed.',
				11,
			],
		]);
	}

}
