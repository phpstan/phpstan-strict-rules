<?php declare(strict_types = 1);

namespace PHPStan\Rules\Functions;

class MissingFunctionParameterTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$rule = new MissingFunctionParameterTypehintRule($this->createBroker([], []));

		return $rule;
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-function-parameter-typehint.php'], [
			[
				'Function globalFunction7() has parameter $b with no typehint specified.',
				9,
			],
			[
				'Function globalFunction7() has parameter $c with no typehint specified.',
				9,
			],
			[
				'Function globalFunction8() has parameter $a with a type array but no value type specified.',
				18,
			],
			[
				'Function globalFunction8() has parameter $b with a type iterable but no value type specified.',
				18,
			],
			[
				'Function globalFunction8() has parameter $c with a type ArrayObject but no value type specified.',
				18,
			],
			[
				'Function globalFunction9() has parameter $a with a type array but no value type specified.',
				27,
			],
			[
				'Function globalFunction9() has parameter $b with a type iterable but no value type specified.',
				27,
			],
			[
				'Function globalFunction9() has parameter $c with a type ArrayObject but no value type specified.',
				27,
			],
			[
				'Function MissingFunctionParameterTypehint\namespacedFunction1() has parameter $d with no typehint specified.',
				37,
			],
		]);
	}

}
