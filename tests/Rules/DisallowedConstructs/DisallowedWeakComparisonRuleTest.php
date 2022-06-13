<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedWeakComparisonRule>
 */
class DisallowedWeakComparisonRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedWeakComparisonRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/weak-comparison.php'], [
			[
				'Weak comparison via "==" is not allowed. Use strong comparison instead.',
				3,
			],
			[
				'Weak comparison via "!=" is not allowed. Use strong comparison instead.',
				5,
			],
		]);
	}

}
