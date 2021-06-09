<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

abstract class OperandInArithmeticIncrementOrDecrementRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return $this->createRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/increment-decrement.php'], $this->getExpectedErrors());
	}

	abstract protected function createRule(OperatorRuleHelper $helper): Rule;

	/**
	 * @return mixed[][]
	 */
	abstract protected function getExpectedErrors(): array;

}
