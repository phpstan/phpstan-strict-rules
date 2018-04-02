<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;

class DynamicCallOnStaticMethodsRuleTest extends \PHPStan\Testing\RuleTestCase
{

	/** @var bool */
	private $checkThisOnly;

	protected function getRule(): Rule
	{
		$broker = $this->createBroker();
		$ruleLevelHelper = new RuleLevelHelper($broker, true, $this->checkThisOnly, true);
		return new DynamicCallOnStaticMethodsRule($ruleLevelHelper);
	}

	public function testRule(): void
	{
		$this->checkThisOnly = false;
		$this->analyse([__DIR__ . '/data/dynamic-calls-on-static-methods.php'], [
			[
				'Dynamic call to static method StrictCalls\ClassWithStaticMethod::foo().',
				14,
			],
			[
				'Dynamic call to static method StrictCalls\ClassWithStaticMethod::foo().',
				22,
			],
			[
				'Dynamic call to static method StrictCalls\ClassUsingTrait::foo().',
				35,
			],
			[
				'Dynamic call to static method StrictCalls\ClassUsingTrait::foo().',
				50,
			],
		]);
	}

	public function testRuleOnThisOnly(): void
	{
		$this->checkThisOnly = true;
		$this->analyse([__DIR__ . '/data/dynamic-calls-on-static-methods.php'], [
			[
				'Dynamic call to static method StrictCalls\ClassWithStaticMethod::foo().',
				14,
			],
			[
				'Dynamic call to static method StrictCalls\ClassUsingTrait::foo().',
				35,
			],
		]);
	}

}
