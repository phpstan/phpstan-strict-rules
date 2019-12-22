<?php declare(strict_types = 1);

namespace PHPStan\Rules\Properties;

class MissingPropertyCallableReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingPropertyCallableReturnTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-property-callable-return-typehint.php'], [
			[
				'Callable property MissingPropertyCallableReturnTypehint\MyClass::$prop1 has no return typehint specified.',
				10,
			],
			[
				'Callable property MissingPropertyCallableReturnTypehint\MyClass::$prop2 has no return typehint specified.',
				15,
			],
			[
				'Callable property MissingPropertyCallableReturnTypehint\MyClass::$prop3 has no return typehint specified.',
				20,
			],
		]);
	}

}
