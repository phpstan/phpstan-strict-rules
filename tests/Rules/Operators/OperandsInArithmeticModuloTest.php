<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticModuloTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticModulo();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in arithmetic modulo.',
				90,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				91,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				92,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				93,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				94,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				94,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				95,
			],
			[
				'Only numeric types are allowed in arithmetic modulo.',
				95,
			],
		]);
	}

}
