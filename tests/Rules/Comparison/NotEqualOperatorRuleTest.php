<?php declare(strict_types = 1);

namespace PHPStan\Rules\Comparison;

use PHPStan\Rules\Rule;

class NotEqualOperatorRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new NotEqualOperatorRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/strict-comparisons.php'], [
			[
				'Not equal operator used, use identity comparison instead (!==).',
				7,
			],
			[
				'Not equal operator used, use identity comparison instead (!==).',
				8,
			],
			[
				'Not equal operator used, use identity comparison instead (!==).',
				9,
			],
		]);
	}

}
