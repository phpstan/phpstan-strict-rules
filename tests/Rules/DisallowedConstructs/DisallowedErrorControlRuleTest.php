<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedErrorControlRule>
 */
class DisallowedErrorControlRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedErrorControlRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/error-control.php'], [
			[
				'Error control operator (`@`) is not allowed.',
				3,
			],
		]);
	}

}
