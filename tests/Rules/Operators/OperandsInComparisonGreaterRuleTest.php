<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonGreaterRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonGreaterRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only numeric types and DateTime objects are allowed in >, string given on the right side.',
				76,
			],
			[
				'Only numeric types and DateTime objects are allowed in >, null given on the right side.',
				79,
			],
			[
				'Only numeric types and DateTime objects are allowed in >, null given on the right side.',
				85,
			],
		]);
	}

}
