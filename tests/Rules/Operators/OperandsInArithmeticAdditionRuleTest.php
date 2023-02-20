<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
use function array_merge;
use const PHP_VERSION_ID;

class OperandsInArithmeticAdditionRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticAdditionRule(
			new OperatorRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			),
			true
		);
	}

	public function testRule(): void
	{
		$messages = [
			[
				'Only numeric types are allowed in +, null given on the right side.',
				28,
			],
			[
				'Only numeric types are allowed in +, null given on the right side.',
				29,
			],
		];

		if (PHP_VERSION_ID < 80000) {
			$messages[] = [
				'Only numeric types are allowed in +, (array<int, string>|false) given on the left side.',
				110,
			];
		}

		$messages = array_merge(
			$messages,
			[
				[
					'Only numeric types are allowed in +, null given on the right side.',
					132,
				],
				[
					'Only numeric types are allowed in +, null given on the right side.',
					133,
				],
			]
		);

		$this->analyse([__DIR__ . '/data/operators.php'], $messages);
	}

}
