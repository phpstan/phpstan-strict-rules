<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInArithmeticExponentiationRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticExponentiationRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in **, string given on the right side.',
				77,
			],
			[
				'Only numeric types are allowed in **, null given on the right side.',
				80,
			],
			[
				'Only numeric types are allowed in **, string given on the left side.',
				81,
			],
			[
				'Only numeric types are allowed in **, null given on the right side.',
				81,
			],
		]);
	}

}
