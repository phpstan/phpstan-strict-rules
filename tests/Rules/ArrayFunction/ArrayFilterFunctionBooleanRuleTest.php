<?php declare(strict_types = 1);

namespace PHPStan\Rules\ArrayFunction;

use PHPStan\Rules\Rule;

class ArrayFilterFunctionBooleanRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new ArrayFilterFunctionBooleanRule($this->createBroker());
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/array-filter.php'], [
			[
				'Call to function array_filter() requires parameter #2 to be callable.',
				5,
			],
			[
				'Call to function array_filter() requires parameter #2 to return boolean.',
				6,
			],
			[
				'Call to function array_filter() requires parameter #2 to return boolean.',
				8,
			],
		]);
	}

}
