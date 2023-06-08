<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowedBacktickRule>
 */
class DisallowedBacktickRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new DisallowedBacktickRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/backtick.php'], [
			[
				'Backtick operator is not allowed. Use shell_exec() instead.',
				3,
			],
		]);
	}

}
