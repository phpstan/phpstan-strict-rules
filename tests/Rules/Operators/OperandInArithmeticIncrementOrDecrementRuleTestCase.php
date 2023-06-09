<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @template T of Rule
 * @extends RuleTestCase<T>
 */
abstract class OperandInArithmeticIncrementOrDecrementRuleTestCase extends RuleTestCase
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

	/**
	 * @return T
	 */
	abstract protected function createRule(OperatorRuleHelper $helper): Rule;

	/**
	 * @return list<array{0: string, 1: int, 2?: string}>
	 */
	abstract protected function getExpectedErrors(): array;

}
