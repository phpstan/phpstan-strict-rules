<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanInBooleanXorRule>
 */
class BooleanInBooleanXorRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInBooleanXorRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class),
			),
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in xor, string given on the left side.',
				63,
			],
			[
				'Only booleans are allowed in xor, string given on the right side.',
				64,
			],
			[
				'Only booleans are allowed in xor, string given on the left side.',
				65,
			],
			[
				'Only booleans are allowed in xor, string given on the right side.',
				65,
			],
			[
				'Only booleans are allowed in xor, mixed given on the right side.',
				66,
			],
			[
				'Only booleans are allowed in xor, mixed given on the left side.',
				67,
			],
		]);
	}

}
