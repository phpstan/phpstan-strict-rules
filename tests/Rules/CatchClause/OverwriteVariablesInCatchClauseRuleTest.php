<?php declare(strict_types = 1);

namespace PHPStan\Rules\CatchClause;

use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OverwriteVariablesInCatchClauseRule>
 */
class OverwriteVariablesInCatchClauseRuleTest extends RuleTestCase
{

	public function getRule(): \PHPStan\Rules\Rule
	{
		return new OverwriteVariablesInCatchClauseRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/catch.php'], [
			[
				'Catch clause overwrites variable $e.',
				15,
			],
		]);
	}

}
