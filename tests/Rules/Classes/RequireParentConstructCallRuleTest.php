<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<RequireParentConstructCallRule>
 */
class RequireParentConstructCallRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new RequireParentConstructCallRule();
	}

	public function testCallToParentConstructor(): void
	{
		$this->analyse([__DIR__ . '/data/call-to-parent-constructor.php'], [
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

}
