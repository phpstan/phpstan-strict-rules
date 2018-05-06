<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class InheritanceOfDeprecatedClassRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new InheritanceOfDeprecatedClassRule($broker);
	}

	public function testInheritanceOfDeprecatedClassInClasses(): void
	{
		require_once __DIR__ . '/data/inheritance-of-deprecated-class-definition.php';
		$this->analyse(
			[__DIR__ . '/data/inheritance-of-deprecated-class-in-classes.php'],
			[
				[
					'Inheritance of deprecated class InheritanceOfDeprecatedClass\DeprecatedFoo in class InheritanceOfDeprecatedClass\Bar2.',
					10,
				],
			]
		);
	}

	public function testInheritanceOfDeprecatedClassInAnonymousClasses(): void
	{
		static::markTestSkipped('The `isAnonymous` method in the ReflectionClass doesn\'t work for some reason.');

		require_once __DIR__ . '/data/inheritance-of-deprecated-class-definition.php';
		$this->analyse(
			[__DIR__ . '/data/inheritance-of-deprecated-class-in-anonymous-classes.php'],
			[
				[
					'Inheritance of deprecated class InheritanceOfDeprecatedClass\DeprecatedFoo in an anonymous class.',
					9,
				],
			]
		);
	}

}
