<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class MissingMethodReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingMethodReturnTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-method-return-typehint.php'], [
			[
				'Method MissingMethodReturnTypehint\FooInterface::a1() has no return typehint specified.',
				8,
			],
			[
				'Method MissingMethodReturnTypehint\FooInterface::a2() has a return type array with no value type specified.',
				10,
			],
			[
				'Method MissingMethodReturnTypehint\FooInterface::a3() has a return type iterable with no value type specified.',
				12,
			],
			[
				'Method MissingMethodReturnTypehint\FooInterface::a4() has a return type ArrayObject with no value type specified.',
				14,
			],
			[
				'Method MissingMethodReturnTypehint\FooParent::b1() has no return typehint specified.',
				21,
			],
			[
				'Method MissingMethodReturnTypehint\FooParent::b2() has a return type array with no value type specified.',
				25,
			],
			[
				'Method MissingMethodReturnTypehint\FooParent::b3() has a return type iterable with no value type specified.',
				29,
			],
			[
				'Method MissingMethodReturnTypehint\FooParent::b4() has a return type ArrayObject with no value type specified.',
				33,
			],
			[
				'Method MissingMethodReturnTypehint\Foo::c1() has no return typehint specified.',
				42,
			],
			[
				'Method MissingMethodReturnTypehint\Foo::c2() has a return type array with no value type specified.',
				46,
			],
			[
				'Method MissingMethodReturnTypehint\Foo::c3() has a return type iterable with no value type specified.',
				50,
			],
			[
				'Method MissingMethodReturnTypehint\Foo::c4() has a return type ArrayObject with no value type specified.',
				54,
			],
		]);
	}

}
