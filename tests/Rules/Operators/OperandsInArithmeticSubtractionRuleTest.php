<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInArithmeticSubtractionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticSubtractionRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in -, string given on the right side.',
				38,
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
		]);
	}

}
