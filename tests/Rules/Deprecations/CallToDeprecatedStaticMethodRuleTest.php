<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class CallToDeprecatedStaticMethodRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new CallToDeprecatedStaticMethodRule($broker);
	}

	public function testDeprecatedStaticMethodCall()
	{
		require_once __DIR__ . '/data/call-to-deprecated-static-method-definition.php';
		$this->analyse(
			[__DIR__ . '/data/call-to-deprecated-static-method.php'],
			[
				[
					'Call to deprecated method deprecatedFoo() of class CheckDeprecatedStaticMethodCall\Foo.',
					6,
				],
				[
					'Call to deprecated method deprecatedFoo2() of class CheckDeprecatedStaticMethodCall\Foo.',
					9,
				],
				[
					'Call to deprecated method deprecatedFoo() of class CheckDeprecatedStaticMethodCall\Foo.',
					16,
				],
			]
		);
	}

}
