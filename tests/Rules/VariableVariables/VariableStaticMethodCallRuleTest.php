<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class VariableStaticMethodCallRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariableStaticMethodCallRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/staticMethods.php'], [
			[
				'Variable static method call on Foo.',
				7,
			],
			[
				'Variable static method call on stdClass.',
				9,
			],
		]);
	}

}
