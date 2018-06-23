<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PHPStan\Rules\RuleLevelHelper;

class FetchingClassConstOfDeprecatedClassRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		$ruleLevelHelper = new RuleLevelHelper($this->createBroker(), true, false, true);

		return new FetchingClassConstOfDeprecatedClassRule($broker, $ruleLevelHelper);
	}

	public function testFetchingClassConstOfDeprecatedClass(): void
	{
		require_once __DIR__ . '/data/fetching-class-const-of-deprecated-class-definition.php';
		$this->analyse(
			[__DIR__ . '/data/fetching-class-const-of-deprecated-class.php'],
			[
				[
					'Fetching class constant class of deprecated class FetchingClassConstOfDeprecatedClass\DeprecatedFoo.',
					6,
				],
				[
					'Fetching deprecated class constant DEPRECATED_FOO of class FetchingClassConstOfDeprecatedClass\Foo.',
					9,
				],
				[
					'Fetching class constant class of deprecated class FetchingClassConstOfDeprecatedClass\DeprecatedFoo.',
					11,
				],
				[
					'Fetching class constant class of deprecated class FetchingClassConstOfDeprecatedClass\DeprecatedFoo.',
					12,
				],
			]
		);
	}

}
