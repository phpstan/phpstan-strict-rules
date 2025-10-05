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
				6,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				7,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				13,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				14,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				31,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				32,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				37,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				38,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				49,
			],
			[
				'Short ternary operator is not allowed. Use null coalesce operator if applicable or consider using long ternary.',
				50,
			],
		]);
	}

}
