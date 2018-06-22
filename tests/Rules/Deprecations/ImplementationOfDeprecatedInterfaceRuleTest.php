<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class ImplementationOfDeprecatedInterfaceRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new ImplementationOfDeprecatedInterfaceRule($broker);
	}

	public function testImplementationOfDeprecatedInterfacesInClasses(): void
	{
		require_once __DIR__ . '/data/implementation-of-deprecated-interface-definition.php';
		$this->analyse(
			[__DIR__ . '/data/implementation-of-deprecated-interface-in-classes.php'],
			[
				[
					'Class ImplementationOfDeprecatedInterface\Foo2 implements deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable.',
					10,
				],
				[
					'Class ImplementationOfDeprecatedInterface\Foo3 implements deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable.',
					15,
				],
				[
					'Class ImplementationOfDeprecatedInterface\Foo3 implements deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable2.',
					15,
				],
			]
		);
	}

	public function testImplementationOfDeprecatedInterfacesInAnonymousClasses(): void
	{
		static::markTestSkipped('The `isAnonymous` method in the ReflectionClass doesn\'t work for some reason.');

		require_once __DIR__ . '/data/implementation-of-deprecated-interface-definition.php';
		$this->analyse(
			[__DIR__ . '/data/implementation-of-deprecated-interface-in-anonymous-classes.php'],
			[
				[
					'Anonymous class implements deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable.',
					9,
				],
				[
					'Anonymous class implements deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable.',
					13,
				],
				[
					'Anonymous class implements deprecated interface ImplementationOfDeprecatedInterface\DeprecatedFooable2.',
					13,
				],
			]
		);
	}

}
