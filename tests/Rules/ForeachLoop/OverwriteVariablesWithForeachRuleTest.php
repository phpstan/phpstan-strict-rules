<?php declare(strict_types = 1);

namespace PHPStan\Rules\ForeachLoop;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<OverwriteVariablesWithForeachRule>
 */
class OverwriteVariablesWithForeachRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OverwriteVariablesWithForeachRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/foreach.php'], [
			[
				'Foreach overwrites $str with its value variable.',
				14,
			],
			[
				'Foreach overwrites $b with its value variable.',
				27,
			],
			[
				'Foreach overwrites $d with its value variable.',
				27,
			],
			[
				'Foreach overwrites $b with its value variable.',
				34,
			],
			[
				'Foreach overwrites $d with its value variable.',
				34,
			],
			[
				'Foreach overwrites $b with its key variable.',
				41,
			],
		]);
	}

	public function testLoopVariableReuse(): void
	{
		$this->analyse([__DIR__ . '/data/foreach-reuse.php'], [
			[
				'Foreach overwrites $x with its value variable.',
				86,
			],
			[
				'Foreach overwrites $x with its value variable.',
				99,
			],
			[
				'Foreach overwrites $x with its value variable.',
				110,
			],
		]);
	}

	public function testBug9940(): void
	{
		$this->analyse([__DIR__ . '/data/bug-9940.php'], []);
	}

}
