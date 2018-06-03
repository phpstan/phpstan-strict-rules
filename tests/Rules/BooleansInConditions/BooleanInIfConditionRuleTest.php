<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class BooleanInIfConditionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInIfConditionRule(
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
				'Only booleans are allowed in an if condition, string given.',
				39,
			],
		]);
	}

}
