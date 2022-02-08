<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedShortTernaryRule>
 */
class DisallowedShortTernaryRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedShortTernaryRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/short-ternary.php'], [
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				3,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				4,
			],
		]);
	}

}
