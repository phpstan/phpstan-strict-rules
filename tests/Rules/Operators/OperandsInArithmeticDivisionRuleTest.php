<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticDivisionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticDivisionRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in /, string given on the right side.',
				64,
			],
			[
				'Only numeric types are allowed in /, array given on the right side.',
				65,
			],
			[
				'Only numeric types are allowed in /, stdClass given on the right side.',
				66,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				67,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				68,
			],
			[
				'Only numeric types are allowed in /, string given on the right side.',
				68,
			],
			[
				'Only numeric types are allowed in /, array given on the right side.',
				69,
			],
			[
				'Only numeric types are allowed in /, array given on the left side.',
				69,
			],
		]);
	}

}
