<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class MissingMethodReturnCallableReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingMethodReturnCallableReturnTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-method-return-callable-return-typehint.php'], [
			[
				'Method MissingMethodReturnCallableReturnTypehint\FooInterface::getFoo() has callable return type with no return typehint specified.',
				8,
			],
			[
				'Method MissingMethodReturnCallableReturnTypehint\Foo::getFoo() has callable return type with no return typehint specified.',
				25,
			],
		]);
	}

}
