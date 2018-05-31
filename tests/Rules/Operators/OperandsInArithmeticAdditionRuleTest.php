<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticAdditionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticAdditionRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in +, string given on the right side.',
				25,
			],
			[
				'Only numeric types are allowed in +, null given on the right side.',
				28,
			],
			[
				'Only numeric types are allowed in +, null given on the right side.',
				29,
			],
			[
				'Only numeric types are allowed in +, string given on the right side.',
				29,
			],
		]);
	}

}
