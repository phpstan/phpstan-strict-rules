<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticDivisionTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticDivision();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in arithmetic division.',
				64,
			],
			[
				'Only numeric types are allowed in arithmetic division.',
				65,
			],
			[
				'Only numeric types are allowed in arithmetic division.',
				66,
			],
			[
				'Only numeric types are allowed in arithmetic division.',
				67,
			],
			[
				'Only numeric types are allowed in arithmetic division.',
				68,
			],
			[
				'Only numeric types are allowed in arithmetic division.',
				68,
			],
			[
				'Only numeric types are allowed in arithmetic division.',
				69,
			],
		]);
	}

}
