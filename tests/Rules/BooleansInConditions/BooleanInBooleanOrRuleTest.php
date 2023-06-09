<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanInBooleanOrRule>
 */
class BooleanInBooleanOrRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInBooleanOrRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			),
			true
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in ||, string given on the left side.',
				25,
			],
			[
				'Only booleans are allowed in ||, string given on the right side.',
				26,
			],
			[
				'Only booleans are allowed in ||, string given on the left side.',
				27,
			],
			[
				'Only booleans are allowed in ||, mixed given on the right side.',
				29,
			],
			[
				'Only booleans are allowed in or, mixed given on the right side.',
				49,
			],
			[
				'Only booleans are allowed in or, mixed given on the left side.',
				50,
			],
		]);
	}

}
