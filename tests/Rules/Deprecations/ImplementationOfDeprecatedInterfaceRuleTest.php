<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class ImplementationOfDeprecatedInterfaceRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new ImplementationOfDeprecatedInterfaceRule($broker);
	}

	public function testImplementationOfDeprecatedInterfacesInClasses()
	{
		require_once __DIR__ . '/data/implementation-of-deprecated-interface-definition.php';
		$this->analyse(
			[__DIR__ . '/data/implementation-of-deprecated-interface-in-classes.php'],
			[
				[
					'Implementation of deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable in class ImplementationOfDeprecatedInterface\Foo2.',
					10,
				],
				[
					'Implementation of deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable in class ImplementationOfDeprecatedInterface\Foo3.',
					15,
				],
				[
					'Implementation of deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable2 in class ImplementationOfDeprecatedInterface\Foo3.',
					15,
				],
			]
		);
	}

	public function testImplementationOfDeprecatedInterfacesInAnonymousClasses()
	{
		$this->markTestSkipped('The `isAnonymous` method in the ReflectionClass doesn\'t work for some reason.');

		require_once __DIR__ . '/data/implementation-of-deprecated-interface-definition.php';
		$this->analyse(
			[__DIR__ . '/data/implementation-of-deprecated-interface-in-anonymous-classes.php'],
			[
				[
					'Implementation of deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable in an anonymous class.',
					9,
				],
				[
					'Implementation of deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable in an anonymous class.',
					13,
				],
				[
					'Implementation of deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable2 in an anonymous class.',
					13,
				],
			]
		);
	}

}
