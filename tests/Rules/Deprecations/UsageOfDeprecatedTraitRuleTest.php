<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class UsageOfDeprecatedTraitRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new UsageOfDeprecatedTraitRule($broker);
	}

	public function testUsageOfDeprecatedTrait(): void
	{
		require_once __DIR__ . '/data/usage-of-deprecated-trait-definition.php';
		$this->analyse(
			[__DIR__ . '/data/usage-of-deprecated-trait.php'],
			[
				[
					'Usage of deprecated trait UsageOfDeprecatedTrait\DeprecatedFooTrait in class UsageOfDeprecatedTrait\Foo.',
					9,
				],
				[
					'Usage of deprecated trait UsageOfDeprecatedTrait\DeprecatedFooTrait in class UsageOfDeprecatedTrait\Foo2.',
					16,
				],
			]
		);
	}

}
