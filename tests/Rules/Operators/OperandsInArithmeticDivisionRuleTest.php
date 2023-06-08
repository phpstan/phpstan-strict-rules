<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandsInArithmeticDivisionRule>
 */
class OperandsInArithmeticDivisionRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticDivisionRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			),
			true
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in /, null given on the right side.',
				67,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				68,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				171,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				172,
			],
		]);
	}

}
