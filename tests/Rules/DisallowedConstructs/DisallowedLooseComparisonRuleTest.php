<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedLooseComparisonRule>
 */
class DisallowedLooseComparisonRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedLooseComparisonRule();
	}

	public function testRule(): void
	{
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
		]);
	}

}
