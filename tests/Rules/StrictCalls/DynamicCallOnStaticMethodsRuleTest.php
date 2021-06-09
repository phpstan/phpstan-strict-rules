<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class DynamicCallOnStaticMethodsRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DynamicCallOnStaticMethodsRule(self::getContainer()->getByType(RuleLevelHelper::class));
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/dynamic-calls-on-static-methods.php'], [
			[
				'Dynamic call to static method StrictCalls\ClassWithStaticMethod::foo().',
				14,
			],
			[
				'Dynamic call to static method StrictCalls\ClassWithStaticMethod::foo().',
				21,
			],
			[
				'Dynamic call to static method StrictCalls\ClassUsingTrait::foo().',
				34,
			],
			[
				'Dynamic call to static method StrictCalls\ClassUsingTrait::foo().',
				46,
			],
		]);
	}

}
