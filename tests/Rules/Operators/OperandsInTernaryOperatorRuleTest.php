<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInTernaryOperatorRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInTernaryOperatorRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'If and else parts of ternary operator are equal (true).',
				113,
			],
			[
				'If and else parts of ternary operator are equal (array()).',
				118,
			],
			[
				'If and else parts of ternary operator are equal (\'string_val\').',
				119,
			],
			[
				'If and else parts of ternary operator are equal (array(23, 24)).',
				121,
			],
			[
				'If and else parts of ternary operator are equal (array(1 => 1)).',
				122,
			],
			[
				'Ternary operator is not needed. Use condition with negation operator.',
				125,
			],
			[
				'Ternary operator is not needed. Use just condition casted to bool.',
				126,
			],
		]);
	}

}
