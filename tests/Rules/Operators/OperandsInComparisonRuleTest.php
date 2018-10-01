<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInComparisonRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInComparisonRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `abs($left - $right) < $epsilon`, where $epsilon is maximum allowed deviation.',
				113,
			],
			[
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `abs($left - $right) < $epsilon`, where $epsilon is maximum allowed deviation.',
				114,
			],
			[
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `abs($left - $right) >= $epsilon`, where $epsilon is maximum allowed deviation.',
				115,
			],
			[
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `abs($left - $right) >= $epsilon`, where $epsilon is maximum allowed deviation.',
				116,
			],
			[
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `$left - $right >= $epsilon`, where $epsilon is maximum allowed deviation.',
				117,
			],
			[
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `$right - $left >= $epsilon`, where $epsilon is maximum allowed deviation.',
				118,
			],
		]);
	}

}
