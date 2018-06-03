<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class BooleanInElseIfConditionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInElseIfConditionRule(
			new BooleanRuleHelper(
				new RuleLevelHelper(
					$this->createBroker(),
					true,
					false,
					true
				)
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
