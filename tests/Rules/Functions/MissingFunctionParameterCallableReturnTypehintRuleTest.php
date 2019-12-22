<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

class MissingFunctionParameterCallableReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$rule = new MissingFunctionParameterCallableReturnTypehintRule($this->createBroker([], []));

		return $rule;
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-function-callable-parameter-callable-return-typehint.php'], [
			[
				'Function globalFunction() has callable parameter $a with no return typehint specified.',
				8,
			],
			[
				'Function globalFunction() has callable parameter $b with no return typehint specified.',
				8,
			],
			[
				'Function globalFunction() has callable parameter $c with no return typehint specified.',
				8,
			],
			[
				'Function MissingFunctionParameterTypehint\namespacedFunction() has callable parameter $d with no return typehint specified.',
				23,
			],
		]);
	}

}
