<?php declare(strict_types = 1);

namespace PHPStan\Rules\Deprecations;

class CallToDeprecatedFunctionRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		$broker = $this->createBroker();
		return new CallToDeprecatedFunctionRule($broker);
	}

	public function testDeprecatedFunctionCall(): void
	{
		require_once __DIR__ . '/data/call-to-deprecated-function-definition.php';
		$this->analyse(
			[__DIR__ . '/data/call-to-deprecated-function.php'],
			[
				[
					'Call to deprecated function CheckDeprecatedFunctionCall\deprecated_foo().',
					8,
				],
				[
					'Call to deprecated function CheckDeprecatedFunctionCall\deprecated_foo().',
					9,
				],
			]
		);
	}

}
