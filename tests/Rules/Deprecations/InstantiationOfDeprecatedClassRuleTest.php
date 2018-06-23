<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PHPStan\Rules\RuleLevelHelper;

class InstantiationOfDeprecatedClassRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		$ruleLevelHelper = new RuleLevelHelper($this->createBroker(), true, false, true);

		return new InstantiationOfDeprecatedClassRule($broker, $ruleLevelHelper);
	}

	public function testInstantiationOfDeprecatedClass(): void
	{
		require_once __DIR__ . '/data/instantiation-of-deprecated-class-definition.php';
		$this->analyse(
			[__DIR__ . '/data/instantiation-of-deprecated-class.php'],
			[
				[
					'Instantiation of deprecated class InstantiationOfDeprecatedClass\DeprecatedFoo.',
					6,
				],
			]
		);
	}

}
