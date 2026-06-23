<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Php\PhpVersion;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandsInArithmeticSubtractionRule>
 */
class OperandsInArithmeticSubtractionRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticSubtractionRule(
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
				'Only numeric types are allowed in -, null given on the right side.',
				41,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				42,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				145,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				146,
			],
		]);
	}

	/**
	 * @requires PHP >= 8.4
	 */
	public function testRuleWithBcMath(): void
	{
		$this->analyse([__DIR__ . '/data/operators-bcmath.php'], [
			[
				'Only numeric types are allowed in -, null given on the right side.',
				56,
			],
			[
				'Only numeric types are allowed in -, null given on the left side.',
				57,
			],
			[
				'Only numeric types are allowed in -, null given on the right side.',
				177,
			],
		]);
	}

}
