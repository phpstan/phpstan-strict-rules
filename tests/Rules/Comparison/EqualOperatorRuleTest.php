<?php declare(strict_types = 1);

namespace PHPStan\Rules\Comparison;

use PHPStan\Rules\Rule;

class EqualOperatorRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new EqualOperatorRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/strict-comparisons.php'], [
			[
				'Equal operator used, use identity comparison instead (===).',
				3,
			],
			[
				'Equal operator used, use identity comparison instead (===).',
				4,
			],
			[
				'Equal operator used, use identity comparison instead (===).',
				5,
			],
		]);
	}

}
