<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanInBooleanNotRule>
 */
class BooleanInBooleanNotRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInBooleanNotRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in a negated boolean, string given.',
				22,
			],
		]);
	}

}
