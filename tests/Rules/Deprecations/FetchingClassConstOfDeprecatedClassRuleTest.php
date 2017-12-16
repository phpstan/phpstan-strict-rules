<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class FetchingClassConstOfDeprecatedClassRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new FetchingClassConstOfDeprecatedClassRule($broker);
	}

	public function testFetchingClassConstOfDeprecatedClass()
	{
		require_once __DIR__ . '/data/fetching-class-const-of-deprecated-class-definition.php';
		$this->analyse(
			[__DIR__ . '/data/fetching-class-const-of-deprecated-class.php'],
			[
				[
					'Fetching class constant of deprecated class FetchingClassConstOfDeprecatedClass\DeprecatedFoo.',
					6,
				],
			]
		);
	}

}
