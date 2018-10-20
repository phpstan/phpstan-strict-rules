<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonSmallerOrEqualRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonSmallerOrEqualRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only numeric types and DateTime objects are allowed in <=, string given on the right side.',
				92,
			],
			[
				'Only numeric types and DateTime objects are allowed in <=, null given on the right side.',
				95,
			],
			[
				'Only numeric types and DateTime objects are allowed in <=, null given on the right side.',
				101,
			],
		]);
	}

}
