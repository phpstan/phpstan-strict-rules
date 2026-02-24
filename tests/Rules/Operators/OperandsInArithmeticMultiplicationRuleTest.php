<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandsInArithmeticMultiplicationRule>
 */
class OperandsInArithmeticMultiplicationRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticMultiplicationRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class),
			),
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in *, null given on the right side.',
				54,
			],
			[
				'Only numeric types are allowed in *, null given on the right side.',
				55,
			],
			[
				'Only numeric types are allowed in *, null given on the right side.',
				158,
			],
			[
				'Only numeric types are allowed in *, null given on the right side.',
				159,
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
				'Only numeric types are allowed in *, null given on the right side.',
				76,
			],
			[
				'Only numeric types are allowed in *, null given on the left side.',
				77,
			],
			[
				'Only numeric types are allowed in *, null given on the right side.',
				197,
			],
		]);
	}

}
