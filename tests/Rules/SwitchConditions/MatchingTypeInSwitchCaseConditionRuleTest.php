<?php declare(strict_types = 1);

namespace PHPStan\Rules\SwitchConditions;

use PHPStan\Rules\Rule;

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
				'Switch condition type (int(1)) does not match case condition \'test\' (string).',
				8,
			],
			[
				'Switch condition type (int(1)) does not match case condition 1 > 2 (bool).',
				8,
			],
			[
				'Switch condition type (string) does not match case condition 1 (int(1)).',
				19,
			],
			[
				'Switch condition type (string) does not match case condition \'test\' (string).',
				19,
			],
			[
				'Switch condition type (string) does not match case condition 1 > 2 (bool).',
				19,
			],
		]);
	}

}
