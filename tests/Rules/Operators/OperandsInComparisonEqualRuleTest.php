<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInComparisonEqualRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonEqualRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/comparison-operators.php'], [
			[
				'Only numeric types and DateTime objects are allowed in ==, string given on the right side.',
				25,
			],
			[
				'Only numeric types and DateTime objects are allowed in ==, null given on the right side.',
				28,
			],
			[
				'Only numeric types and DateTime objects are allowed in ==, null given on the right side.',
				34,
			],
			[
				'Only numeric types and DateTime objects are allowed in ==, (array<int, string>|false) given on the '
					. 'left side.',
				148,
			],
		]);
	}

}
