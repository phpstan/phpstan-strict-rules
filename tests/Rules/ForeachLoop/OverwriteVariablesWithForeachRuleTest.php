<?php declare(strict_types = 1);

namespace PHPStan\Rules\ForeachLoop;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

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
				26,
			],
			[
				'Foreach overwrites $d with its value variable.',
				26,
			],
			[
				'Foreach overwrites $b with its value variable.',
				32,
			],
			[
				'Foreach overwrites $d with its value variable.',
				32,
			],
			[
				'Foreach overwrites $b with its key variable.',
				38,
			],
		]);
	}

}
