<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonSmallerRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonSmallerRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only numeric types and DateTime objects are allowed in <, string given on the right side.',
				60,
			],
			[
				'Only numeric types and DateTime objects are allowed in <, null given on the right side.',
				63,
			],
			[
				'Only numeric types and DateTime objects are allowed in <, null given on the right side.',
				69,
			],
		]);
	}

}
