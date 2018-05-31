<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticSubtractionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticSubtractionRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in -, string given on the right side.',
				38,
			],
			[
				'Only numeric types are allowed in -, array given on the right side.',
				39,
			],
			[
				'Only numeric types are allowed in -, stdClass given on the right side.',
				40,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				41,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				42,
			],
			[
				'Only numeric types are allowed in -, string given on the right side.',
				42,
			],
			[
				'Only numeric types are allowed in -, array given on the right side.',
				43,
			],
			[
				'Only numeric types are allowed in -, array given on the left side.',
				43,
			],
		]);
	}

}
