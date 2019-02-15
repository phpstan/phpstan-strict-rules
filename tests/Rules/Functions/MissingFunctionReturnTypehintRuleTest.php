<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

class MissingFunctionReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$rule = new MissingFunctionReturnTypehintRule($this->createBroker([], []));

		return $rule;
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-function-return-typehint.php'], [
			[
				'Function globalFunction1() has no return typehint specified.',
				5,
			],
			[
				'Function globalFunction4() has a return type array with no value type specified.',
				27,
			],
			[
				'Function globalFunction5() has a return type iterable with no value type specified.',
				31,
			],
			[
				'Function globalFunction6() has a return type ArrayObject with no value type specified.',
				35,
			],
			[
				'Function MissingFunctionReturnTypehint\namespacedFunction1() has no return typehint specified.',
				42,
			],
		]);
	}

}
