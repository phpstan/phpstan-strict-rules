<?php declare(strict_types = 1);

namespace PHPStan\Rules\StrictCalls;

use PHPStan\Rules\Rule;

class StrictFunctionCallsRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new StrictFunctionCallsRule($this->createBroker());
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/strict-calls.php'], [
			[
				'Call to function in_array() requires parameter #3 to be true.',
				5,
			],
			[
				'Call to function in_array() requires parameter #3 to be true.',
				7,
			],
			[
				'Call to function in_array() requires parameter #3 to be true.',
				8,
			],
			[
				'Call to function array_search() requires parameter #3 to be true.',
				10,
			],
			[
				'Call to function array_search() requires parameter #3 to be true.',
				12,
			],
			[
				'Call to function array_search() requires parameter #3 to be true.',
				13,
			],
			[
				'Call to function base64_decode() requires parameter #2 to be true.',
				15,
			],
			[
				'Call to function base64_decode() requires parameter #2 to be true.',
				17,
			],
			[
				'Call to function base64_decode() requires parameter #2 to be true.',
				18,
			],
			[
				'Call to function array_keys() requires parameter #3 to be true.',
				20,
			],
			[
				'Call to function array_keys() requires parameter #3 to be true.',
				22,
			],
			[
				'Call to function array_keys() requires parameter #3 to be true.',
				23,
			],
		]);
	}

}
