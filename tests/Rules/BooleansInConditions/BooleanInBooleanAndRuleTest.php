<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

/**
 * @extends \PHPStan\Testing\RuleTestCase<BooleanInBooleanAndRule>
 */
class BooleanInBooleanAndRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new BooleanInBooleanAndRule(
			new BooleanRuleHelper(
				self::getContainer()->getByType(RuleLevelHelper::class)
			)
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/conditions.php'], [
			[
				'Only booleans are allowed in &&, string given on the left side.',
				15,
			],
			[
				'Only booleans are allowed in &&, string given on the right side.',
				16,
			],
			[
				'Only booleans are allowed in &&, string given on the left side.',
				17,
			],
			[
				'Only booleans are allowed in &&, string given on the right side.',
				17,
			],
			[
				'Only booleans are allowed in &&, mixed given on the right side.',
				19,
			],
		]);
	}

	public function testBug104(): void
	{
		$this->analyse([__DIR__ . '/data/bug-104.php'], [
			[
				'Only booleans are allowed in &&, string given on the right side.',
				13,
			],
		]);
	}

	public function testLogicalAnd(): void
	{
		$this->analyse([__DIR__ . '/data/logical-and.php'], [
			[
				'Only booleans are allowed in &&, string|false given on the left side.',
				14,
			],
			[
				'Only booleans are allowed in &&, mixed given on the right side.',
				14,
			],
		]);
	}

}
