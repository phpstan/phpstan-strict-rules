<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class OperandsInArithmeticDivisionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticDivisionRule(
			new OperatorRuleHelper(
				new RuleLevelHelper($this->createBroker(), true, false, true),
                $this->createMock(TypeStringResolver::class),
                ''
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/arithmetic-operators.php'], [
			[
				'Only numeric types are allowed in /, string given on the right side.',
				64,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				67,
			],
			[
				'Only numeric types are allowed in /, null given on the right side.',
				68,
			],
			[
				'Only numeric types are allowed in /, string given on the right side.',
				68,
			],
		]);
	}

}
