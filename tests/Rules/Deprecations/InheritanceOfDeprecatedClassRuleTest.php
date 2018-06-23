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
					'Class InheritanceOfDeprecatedClass\Bar2 extends deprecated class InheritanceOfDeprecatedClass\DeprecatedFoo.',
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
					'Anonymous class extends deprecated class InheritanceOfDeprecatedClass\DeprecatedFoo.',
					9,
				],
			]
		);
	}

}
