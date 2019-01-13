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
				'Variable static property access on Foo.',
				7,
			],
			[
				'Variable static property access on Foo.',
				8,
			],
			[
				'Variable static property access on Foo.',
				10,
			],
			[
				'Variable static property access on Foo.',
				11,
			],
			[
				'Variable static property access on stdClass.',
				13,
			],
		]);
	}

}
