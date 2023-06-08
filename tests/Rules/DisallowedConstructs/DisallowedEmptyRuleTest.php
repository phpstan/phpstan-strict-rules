<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedEmptyRule>
 */
class DisallowedEmptyRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedEmptyRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/empty.php'], [
			[
				'Construct empty() is not allowed. Use more strict comparison.',
				3,
			],
		]);
	}

}
