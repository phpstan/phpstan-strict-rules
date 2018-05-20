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
				'Only numeric types or arrays are allowed in arithmetic addition.',
				25,
			],
			[
				'Only numeric types or arrays are allowed in arithmetic addition.',
				26,
			],
			[
				'Only numeric types or arrays are allowed in arithmetic addition.',
				27,
			],
			[
				'Only numeric types or arrays are allowed in arithmetic addition.',
				28,
			],
			[
				'Only numeric types or arrays are allowed in arithmetic addition.',
				29,
			],
			[
				'Only numeric types or arrays are allowed in arithmetic addition.',
				29,
			],
			[
				'Only numeric types or arrays are allowed in arithmetic addition.',
				30,
			],
		]);
	}

}
