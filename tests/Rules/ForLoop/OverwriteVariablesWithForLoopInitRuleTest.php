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
				21,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				21,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				26,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				38,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				38,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				43,
			],
			[
				'For loop initial assignment overwrites variable $j.',
				43,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				55,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				60,
			],
		]);
	}

	public function testLoopVariableReuse(): void
	{
		$this->analyse([__DIR__ . '/data/for-reuse.php'], [
			[
				'For loop initial assignment overwrites variable $i.',
				61,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				70,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				78,
			],
			[
				'For loop initial assignment overwrites variable $i.',
				87,
			],
		]);
	}

	protected function shouldPolluteScopeWithLoopInitialAssignments(): bool
	{
		return false;
	}

}
