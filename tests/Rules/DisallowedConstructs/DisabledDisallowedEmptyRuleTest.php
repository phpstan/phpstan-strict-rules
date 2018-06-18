<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;

class DisabledDisallowedEmptyRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedEmptyRule(false);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/empty.php'], []);
	}

}
