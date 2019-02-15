<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class MissingMethodParameterTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingMethodParameterTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-method-parameter-typehint.php'], [
			[
				'Method MissingMethodParameterTypehint\FooInterface::a1() has parameter $p1 with no typehint specified.',
				8,
			],
			[
				'Method MissingMethodParameterTypehint\FooInterface::a1() has parameter $p2 with no typehint specified.',
				8,
			],
			[
				'Method MissingMethodParameterTypehint\FooInterface::a1() has parameter $p3 with no typehint specified.',
				8,
			],
			[
				'Method MissingMethodParameterTypehint\FooInterface::a2() has parameter $p1 with a type array but no value type specified.',
				10,
			],
			[
				'Method MissingMethodParameterTypehint\FooInterface::a3() has parameter $p1 with a type iterable but no value type specified.',
				12,
			],
			[
				'Method MissingMethodParameterTypehint\FooInterface::a4() has parameter $p1 with a type ArrayObject but no value type specified.',
				14,
			],
			[
				'Method MissingMethodParameterTypehint\FooParent::b1() has parameter $p1 with no typehint specified.',
				21,
			],
			[
				'Method MissingMethodParameterTypehint\FooParent::b2() has parameter $p1 with a type array but no value type specified.',
				25,
			],
			[
				'Method MissingMethodParameterTypehint\FooParent::b3() has parameter $p1 with a type iterable but no value type specified.',
				29,
			],
			[
				'Method MissingMethodParameterTypehint\FooParent::b4() has parameter $p1 with a type ArrayObject but no value type specified.',
				33,
			],
			[
				'Method MissingMethodParameterTypehint\Foo::c1() has parameter $p1 with no typehint specified.',
				42,
			],
			[
				'Method MissingMethodParameterTypehint\Foo::c2() has parameter $p1 with a type array but no value type specified.',
				46,
			],
			[
				'Method MissingMethodParameterTypehint\Foo::c3() has parameter $p1 with a type iterable but no value type specified.',
				50,
			],
			[
				'Method MissingMethodParameterTypehint\Foo::c4() has parameter $p1 with a type ArrayObject but no value type specified.',
				54,
			],
			[
				'Method MissingMethodParameterTypehint\Foo::a1() has parameter $p2 with a type array but no value type specified.',
				68,
			],
			[
				'Method MissingMethodParameterTypehint\Foo::a1() has parameter $p3 with no typehint specified.',
				68,
			],
		]);
	}

}
