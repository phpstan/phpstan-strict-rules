<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

use PHPStan\Rules\RuleLevelHelper;

class AccessDeprecatedStaticPropertyRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		$ruleLevelHelper = new RuleLevelHelper($this->createBroker(), true, false, true);

		return new AccessDeprecatedStaticPropertyRule($broker, $ruleLevelHelper);
	}

	public function testAccessDeprecatedStaticProperty(): void
	{
		require_once __DIR__ . '/data/access-deprecated-static-property-definition.php';
		$this->analyse(
			[__DIR__ . '/data/access-deprecated-static-property.php'],
			[
				[
					'Access to deprecated static property $deprecatedFoo of class AccessDeprecatedStaticProperty\Foo.',
					8,
				],
				[
					'Access to deprecated static property $deprecatedFoo of class AccessDeprecatedStaticProperty\Foo.',
					9,
				],
				[
					'Access to deprecated static property $deprecatedFoo of class AccessDeprecatedStaticProperty\Foo.',
					16,
				],
				[
					'Access to deprecated static property $deprecatedFoo of class AccessDeprecatedStaticProperty\Foo.',
					17,
				],
				[
					'Access to deprecated static property $deprecatedFooFromTrait of class AccessDeprecatedStaticProperty\FooTrait.',
					22,
				],
				[
					'Access to deprecated static property $deprecatedFooFromTrait of class AccessDeprecatedStaticProperty\FooTrait.',
					23,
				],
				[
					'Access to deprecated static property $deprecatedFooFromTrait of class AccessDeprecatedStaticProperty\Foo.',
					30,
				],
				[
					'Access to deprecated static property $deprecatedFooFromTrait of class AccessDeprecatedStaticProperty\Foo.',
					31,
				],
			]
		);
	}

}
