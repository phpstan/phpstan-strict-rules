<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInArithmeticModuloRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticModuloRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in %, string given on the right side.',
				90,
			],
			[
				'Only numeric types are allowed in %, null given on the right side.',
				93,
			],
			[
				'Only numeric types are allowed in %, null given on the right side.',
				94,
			],
			[
				'Only numeric types are allowed in %, string given on the right side.',
				94,
			],
		]);
	}

}
