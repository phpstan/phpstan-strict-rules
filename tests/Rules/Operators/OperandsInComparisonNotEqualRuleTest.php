<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonNotEqualRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonNotEqualRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only numeric types and DateTime objects are allowed in !=, string given on the right side.',
				41,
			],
			[
				'Only numeric types and DateTime objects are allowed in !=, null given on the right side.',
				44,
			],
			[
				'Only numeric types and DateTime objects are allowed in !=, null given on the right side.',
				50,
			],
			[
				'Only numeric types and DateTime objects are allowed in !=, string given on the right side.',
				53,
			],
		]);
	}

}
