<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class CallToDeprecatedMethodRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new CallToDeprecatedMethodRule($broker);
	}

	public function testDeprecatedMethodCall()
	{
		require_once __DIR__ . '/data/call-to-deprecated-method-definition.php';
		$this->analyse(
			[__DIR__ . '/data/call-to-deprecated-method.php'],
			[
				[
					'Call to deprecated method deprecatedFoo() of class CheckDeprecatedMethodCall\Foo.',
					7,
				],
				[
					'Call to deprecated method deprecatedFoo2() of class CheckDeprecatedMethodCall\Foo.',
					11,
				],
			]
		);
	}

}
