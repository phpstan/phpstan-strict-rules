<?php declare(strict_types = 1);

namespace PHPStan\Rules\SwitchConditions;

use PHPStan\Rules\Rule;

/**
 * @extends \PHPStan\Testing\RuleTestCase<MatchingTypeInSwitchCaseConditionRule>
 */
class MatchingTypeInSwitchCaseConditionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new MatchingTypeInSwitchCaseConditionRule(new \PhpParser\PrettyPrinter\Standard());
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/matching-type.php'], [
			[
				'Switch condition type (1) does not match case condition \'test\' (string).',
				11,
			],
			[
				'Switch condition type (1) does not match case condition 1 > 2 (false).',
				13,
			],
			[
				'Switch condition type (\'1\') does not match case condition 1 (int).',
				20,
			],
			[
				'Switch condition type (\'1\') does not match case condition \'test\' (string).',
				22,
			],
			[
				'Switch condition type (\'1\') does not match case condition 1 > 2 (false).',
				24,
			],
		]);
	}

}
