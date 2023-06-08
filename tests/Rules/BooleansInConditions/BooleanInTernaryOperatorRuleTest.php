<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanInTernaryOperatorRule>
 */
class BooleanInTernaryOperatorRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInTernaryOperatorRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in a ternary operator condition, string given.',
				44,
			],
		]);
	}

}
