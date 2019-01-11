<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class VariablePropertyFetchRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariablePropertyFetchRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/properties.php'], [
			[
				'Variable properties are not allowed.',
				6,
			],
			[
				'Variable properties are not allowed.',
				9,
			],
		]);
	}

}
