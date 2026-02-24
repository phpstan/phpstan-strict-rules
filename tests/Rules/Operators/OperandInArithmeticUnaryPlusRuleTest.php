<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Php\PhpVersion;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandInArithmeticUnaryPlusRule>
 */
class OperandInArithmeticUnaryPlusRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandInArithmeticUnaryPlusRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class),
				self::getContainer()->getByType(PhpVersion::class),
			),
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in unary +, null given.',
				225,
			],
		]);
	}

	/**
	 * @requires PHP >= 8.4
	 */
	public function testRuleWithBcMath(): void
	{
		$this->analyse([__DIR__ . '/data/operators-bcmath.php'], []);
	}

}
