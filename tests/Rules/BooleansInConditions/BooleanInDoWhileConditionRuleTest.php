<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanInDoWhileConditionRule>
 */
class BooleanInDoWhileConditionRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInDoWhileConditionRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class),
			),
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in a do-while condition, string given.',
				60,
			],
		]);
	}

}
