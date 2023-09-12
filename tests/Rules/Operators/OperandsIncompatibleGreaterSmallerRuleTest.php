<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OperandsIncompatibleGreaterSmallerRule>
 */
class OperandsIncompatibleGreaterSmallerRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsIncompatibleGreaterSmallerRule(
			true
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/greater-smaller.php'], [
			[
				'Comparison operator ">" between bool and bool is not allowed.',
				24,
			],
			[
				'Comparison operator ">" between int and bool is not allowed.',
				25,
			],
			[
				'Comparison operator ">" between int and int|false is not allowed.',
				26,
			],
			[
				'Comparison operator "<=" between int and bool|int is not allowed.',
				28,
			],
			[
				'Comparison operator "<=" between bool|int and int is not allowed.',
				29,
			],
			[
				'Comparison operator "<=" between bool|int and string is not allowed.',
				30,
			],
			[
				'Comparison operator "<=" between int|false and int is not allowed.',
				32,
			],
			[
				'Comparison operator "<=" between int|false and string is not allowed.',
				33,
			],
			[
				'Comparison operator "<=>" between int and int|false is not allowed.',
				40,
			],
			[
				'Comparison operator "<=>" between int|false and int is not allowed.',
				41,
			],
			[
				'Comparison operator ">=" between int|false and int is not allowed.',
				50,
			],
		]);
	}

}
