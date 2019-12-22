<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

class MissingFunctionReturnCallableReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$rule = new MissingFunctionReturnCallableReturnTypehintRule($this->createBroker([], []));

		return $rule;
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-function-callable-return-callable-return-typehint.php'], [
			[
				'Function globalFunction1() has callable return type with no return typehint specified.',
				5,
			],
			[
				'Function MissingFunctionReturnTypehint\namespacedFunction1() has callable return type with no return typehint specified.',
				33,
			],
		]);
	}

}
