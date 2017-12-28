<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;

class BooleanInIfConditionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInIfConditionRule();
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
