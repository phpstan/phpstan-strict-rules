<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedLooseComparisonRule>
 */
class DisallowedLooseComparisonRuleTest extends RuleTestCase
{

	private bool $includeOperandTypesInErrorMessage;

	protected function getRule(): Rule
	{
		return new DisallowedLooseComparisonRule(
			$this->includeOperandTypesInErrorMessage,
		);
	}

	public function testRuleWithoutOperandTypesInErrorMessage(): void
	{
		$this->includeOperandTypesInErrorMessage = false;
		$this->analyse([__DIR__ . '/data/weak-comparison.php'], [
			[
				'Loose comparison via "==" is not allowed.',
				3,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" is not allowed.',
				5,
				'Use strict comparison via "!==" instead.',
			],
			[
				'Loose comparison via "==" is not allowed.',
				8,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" is not allowed.',
				10,
				'Use strict comparison via "!==" instead.',
			],
			[
				'Loose comparison via "==" is not allowed.',
				13,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" is not allowed.',
				15,
				'Use strict comparison via "!==" instead.',
			],
			[
				'Loose comparison via "==" is not allowed.',
				18,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" is not allowed.',
				20,
				'Use strict comparison via "!==" instead.',
			],
		]);
	}

	public function testRuleWithOperandTypesInErrorMessage(): void
	{
		$this->includeOperandTypesInErrorMessage = true;
		$this->analyse([__DIR__ . '/data/weak-comparison.php'], [
			[
				'Loose comparison via "==" between int and int is not allowed.',
				3,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" between int and int is not allowed.',
				5,
				'Use strict comparison via "!==" instead.',
			],
			[
				'Loose comparison via "==" between DateTime and float is not allowed.',
				8,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" between float and DateTime is not allowed.',
				10,
				'Use strict comparison via "!==" instead.',
			],
			[
				'Loose comparison via "==" between DateTime and null is not allowed.',
				13,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" between null and DateTime is not allowed.',
				15,
				'Use strict comparison via "!==" instead.',
			],
			[
				'Loose comparison via "==" between DateTime and DateTime is not allowed.',
				18,
				'Use strict comparison via "===" instead.',
			],
			[
				'Loose comparison via "!=" between DateTime and DateTime is not allowed.',
				20,
				'Use strict comparison via "!==" instead.',
			],
		]);
	}

}
