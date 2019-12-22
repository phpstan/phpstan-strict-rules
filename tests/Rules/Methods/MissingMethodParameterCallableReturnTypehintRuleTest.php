<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class MissingMethodParameterCallableReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingMethodParameterCallableReturnTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-method-parameter-callable-return-typehint.php'], [
			[
				'Method MissingMethodParameterCallableReturnTypehint\FooInterface::getFoo() has callable parameter $p1 with no return typehint specified.',
				11,
			],
			[
				'Method MissingMethodParameterCallableReturnTypehint\FooParent::getBar() has callable parameter $p2 with no return typehint specified.',
				21,
			],
			[
				'Method MissingMethodParameterCallableReturnTypehint\Foo::getFoo() has callable parameter $p1 with no return typehint specified.',
				34,
			],
			[
				'Method MissingMethodParameterCallableReturnTypehint\Foo::getBar() has callable parameter $p2 with no return typehint specified.',
				42,
			],
			[
				'Method MissingMethodParameterCallableReturnTypehint\Foo::getBaz() has callable parameter $p4 with no return typehint specified.',
				51,
			],
		]);
	}

}
