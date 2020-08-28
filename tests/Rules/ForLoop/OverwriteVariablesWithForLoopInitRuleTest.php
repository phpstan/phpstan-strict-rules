<?php declare(strict_types = 1);

namespace PHPStan\Rules\ForLoop;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @template-extends RuleTestCase<OverwriteVariablesWithForLoopInitRule>
 */
class OverwriteVariablesWithForLoopInitRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OverwriteVariablesWithForLoopInitRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/data.php'], [
			[
				'For loop initial assignment overwrites variable $i.',
				9,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				20,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				20,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				24,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				35,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				35,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				39,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				39,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				50,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				54,
			],
		]);
	}

}
