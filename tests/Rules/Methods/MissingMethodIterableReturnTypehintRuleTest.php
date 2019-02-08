<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

class MissingMethodIterableReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingMethodIterableReturnTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse(
			[__DIR__ . '/data/missing-method-iterable-return-typehint.php'],
			[
				[
					'Method MissingMethodIterableReturnTypehint\FooInterface::a1() has a return type array with no value type specified.',
					8,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooInterface::a2() has a return type array with no value type specified.',
					13,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooInterface::a5() has a return type array with no value type specified.',
					28,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooParent::b1() has a return type iterable with no value type specified.',
					39,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooParent::b2() has a return type iterable with no value type specified.',
					47,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooParent::b5() has a return type iterable with no value type specified.',
					71,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooTrait::c1() has a return type ArrayObject with no value type specified.',
					91,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooTrait::c2() has a return type ArrayObject with no value type specified.',
					99,
				],
				[
					'Method MissingMethodIterableReturnTypehint\FooTrait::c5() has a return type ArrayObject with no value type specified.',
					123,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::a1() has a return type array with no value type specified.',
					144,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::a2() has a return type array with no value type specified.',
					148,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::a5() has a return type array with no value type specified.',
					160,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::b1() has a return type iterable with no value type specified.',
					172,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::b2() has a return type iterable with no value type specified.',
					177,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::b5() has a return type iterable with no value type specified.',
					192,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::c1() has a return type ArrayObject with no value type specified.',
					205,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::c2() has a return type ArrayObject with no value type specified.',
					210,
				],
				[
					'Method MissingMethodIterableReturnTypehint\Foo::c5() has a return type ArrayObject with no value type specified.',
					234,
				],
				[
					'Method MissingMethodIterableReturnTypehint\SubFoo::a3() has a return type array with no value type specified.',
					269,
				],
				[
					'Method MissingMethodIterableReturnTypehint\SubFoo::a4() has a return type array with no value type specified.',
					276,
				],
				[
					'Method MissingMethodIterableReturnTypehint\SubFoo::b3() has a return type iterable with no value type specified.',
					314,
				],
				[
					'Method MissingMethodIterableReturnTypehint\SubFoo::b4() has a return type iterable with no value type specified.',
					322,
				],
				[
					'Method MissingMethodIterableReturnTypehint\SubFoo::c3() has a return type ArrayObject with no value type specified.',
					362,
				],
				[
					'Method MissingMethodIterableReturnTypehint\SubFoo::c4() has a return type ArrayObject with no value type specified.',
					370,
				],
			]
		);
	}

}
