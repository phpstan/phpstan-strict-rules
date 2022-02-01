<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
use const PHP_VERSION_ID;

/**
 * @extends RuleTestCase<DynamicCallOnStaticMethodsCallableRule>
 */
class DynamicCallOnStaticMethodsCallableRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DynamicCallOnStaticMethodsCallableRule(self::getContainer()->getByType(RuleLevelHelper::class));
	}

	public function testRule(): void
	{
		if (PHP_VERSION_ID < 80100) {
			self::markTestSkipped('Test requires PHP 8.1.');
		}

		$this->analyse([__DIR__ . '/data/dynamic-calls-on-static-methods-callables.php'], [
			[
				'Dynamic call to static method StrictCallsCallables\ClassWithStaticMethod::foo().',
				14,
			],
			[
				'Dynamic call to static method StrictCallsCallables\ClassWithStaticMethod::foo().',
				21,
			],
			[
				'Dynamic call to static method StrictCallsCallables\ClassUsingTrait::foo().',
				34,
			],
			[
				'Dynamic call to static method StrictCallsCallables\ClassUsingTrait::foo().',
				46,
			],
		]);
	}

}
