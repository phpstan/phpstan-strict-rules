<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

/**
 * @extends \PHPStan\Testing\RuleTestCase<BooleanInBooleanOrRule>
 */
class BooleanInBooleanOrRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInBooleanOrRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
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
		]);
	}

}
