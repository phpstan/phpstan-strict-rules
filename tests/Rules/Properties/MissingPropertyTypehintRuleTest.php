<?php declare(strict_types = 1);

namespace PHPStan\Rules\Properties;

class MissingPropertyTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new MissingPropertyTypehintRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/missing-property-typehint.php'], [
			[
				'Property MissingPropertyTypehint\MyClass::$prop1 has no typehint specified.',
				7,
			],
			[
				'Property MissingPropertyTypehint\MyClass::$prop2 has no typehint specified.',
				9,
			],
			[
				'Property MissingPropertyTypehint\MyClass::$prop3 has no typehint specified.',
				14,
			],
			[
				'Property MissingPropertyTypehint\MyClass::$prop4 has a type array but no value type specified.',
				19,
			],
			[
				'Property MissingPropertyTypehint\MyClass::$prop5 has a type iterable but no value type specified.',
				24,
			],
			[
				'Property MissingPropertyTypehint\MyClass::$prop6 has a type ArrayObject but no value type specified.',
				29,
			],
		]);
	}

}
