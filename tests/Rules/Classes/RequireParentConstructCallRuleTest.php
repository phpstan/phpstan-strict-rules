<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use const PHP_VERSION_ID;

class RequireParentConstructCallRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new RequireParentConstructCallRule();
	}

	public function testCallToParentConstructor(): void
	{
		$this->analyse([__DIR__ . '/data/call-to-parent-constructor.php'], [
			[
				'IpsumCallToParentConstructor::__construct() calls parent constructor but parent does not have one.',
				31,
			],
			[
				'BCallToParentConstructor::__construct() does not call parent constructor from ACallToParentConstructor.',
				51,
			],
			[
				'FCallToParentConstructor::__construct() does not call parent constructor from DCallToParentConstructor.',
				76,
			],
			[
				'BarSoapClient::__construct() does not call parent constructor from SoapClient.',
				119,
			],
			[
				'StaticCallOnAVariable::__construct() does not call parent constructor from FooCallToParentConstructor.',
				130,
			],
		]);
	}

	public function testCheckInTraits(): void
	{
		$this->analyse([__DIR__ . '/data/call-to-parent-constructor-in-trait.php'], []);
	}

	public function testCallsParentButHasNotParent(): void
	{
		if (PHP_VERSION_ID >= 70400) {
			self::markTestSkipped('This test does not support PHP 7.4 or higher.');
		}
		$this->analyse([__DIR__ . '/data/call-to-parent-constructor-php-lt-74.php'], [
			[
				'CCallToParentConstructor::__construct() calls parent constructor but does not extend any class.',
				6,
			],
		]);
	}

}
