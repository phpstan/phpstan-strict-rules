<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

class OperandsInArithmeticSubtractionRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticSubtractionRule(
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
				'Only numeric types are allowed in -, null given on the right side.',
				41,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				42,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				145,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				146,
			],
		]);
	}

}
