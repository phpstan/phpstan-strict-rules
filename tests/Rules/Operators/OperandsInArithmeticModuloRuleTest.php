<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandsInArithmeticModuloRule>
 */
class OperandsInArithmeticModuloRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticModuloRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class),
			),
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in %, null given on the right side.',
				93,
			],
			[
				'Only numeric types are allowed in %, null given on the right side.',
				94,
			],
			[
				'Only numeric types are allowed in %, null given on the right side.',
				197,
			],
			[
				'Only numeric types are allowed in %, null given on the right side.',
				198,
			],
		]);
	}

	/**
	 * @requires PHP >= 8.4
	 */
	public function testRuleWithBcMath(): void
	{
		$this->analyse([__DIR__ . '/data/operators-bcmath.php'], [
			[
				'Only numeric types are allowed in %, null given on the right side.',
				136,
			],
			[
				'Only numeric types are allowed in %, null given on the left side.',
				137,
			],
			[
				'Only numeric types are allowed in %, null given on the right side.',
				257,
			],
		]);
	}

}
