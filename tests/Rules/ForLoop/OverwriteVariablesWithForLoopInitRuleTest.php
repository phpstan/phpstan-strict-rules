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
				16,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				16,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				20,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				27,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				27,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				31,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				31,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				38,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				42,
			],
		]);
	}

}
