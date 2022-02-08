<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

class BooleanInElseIfConditionRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInElseIfConditionRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in an elseif condition, string given.',
				35,
			],
		]);
	}

}
