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
				'Variable property access on stdClass.',
				6,
			],
			[
				'Variable property access on stdClass.',
				9,
			],
		]);
	}

}
