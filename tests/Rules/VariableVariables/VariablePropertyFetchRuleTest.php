<?php declare(strict_types = 1);

namespace PHPStan\Rules\VariableVariables;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<VariablePropertyFetchRule>
 */
class VariablePropertyFetchRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new VariablePropertyFetchRule($this->createReflectionProvider(), [
			'stdClass',
			'SimpleXMLElement',
		]);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/properties.php'], [
			[
				'Variable property access on VariablePropertyFetch\Foo.',
				24,
			],
		]);
	}

}
