<?php declare(strict_types = 1);

namespace PHPStan\Rules\ArrayTypes;

final class MissingArrayValueTypeInMethodParameterRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingArrayValueTypeInMethodParameterRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-array-types-in-method-parameter-typehint.php'], [
			/* not detected by now
			[
				'Method MissingArrayValueTypeInMethodParameter\FooInterface::getFoo() has parameter $p1 of type array with no value typehint specified.',
				11,
			],
			*/
			[
				'Method MissingArrayValueTypeInMethodParameter\FooParent::getBar() has parameter $p2 of type array with no value typehint specified.',
				18,
			],
			[
				'Method MissingArrayValueTypeInMethodParameter\Foo::getBar() has parameter $p2 of type array with no value typehint specified.',
				39,
			],
		]);
	}

}
