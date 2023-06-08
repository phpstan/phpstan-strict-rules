<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandsInArithmeticExponentiationRule>
 */
class OperandsInArithmeticExponentiationRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticExponentiationRule(
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
				'Only numeric types are allowed in **, null given on the right side.',
				80,
			],
			[
				'Only numeric types are allowed in **, null given on the right side.',
				81,
			],
			[
				'Only numeric types are allowed in **, null given on the right side.',
				184,
			],
			[
				'Only numeric types are allowed in **, null given on the right side.',
				185,
			],
		]);
	}

}
