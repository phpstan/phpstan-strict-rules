<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class AccessDeprecatedPropertyRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new AccessDeprecatedPropertyRule($broker);
	}

	public function testAccessDeprecatedProperty()
	{
		require_once __DIR__ . '/data/access-deprecated-property-definition.php';
		$this->analyse(
			[__DIR__ . '/data/access-deprecated-property.php'],
			[
				[
					'Access to deprecated property deprecatedFoo of class AccessDeprecatedProperty\Foo.',
					10,
				],
				[
					'Access to deprecated property deprecatedFoo of class AccessDeprecatedProperty\Foo.',
					11,
				],
				[
					'Access to deprecated property deprecatedFooFromTrait of class AccessDeprecatedProperty\Foo.',
					16,
				],
				[
					'Access to deprecated property deprecatedFooFromTrait of class AccessDeprecatedProperty\Foo.',
					17,
				],
			]
		);
	}

}
