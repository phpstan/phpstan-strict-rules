<?php

namespace OverwriteVariablesWithForLoopInitReuse;

class Foo
{

	public function sequentialLoops(): void
	{
		for ($i = 0; $i < 10; $i++) {
			echo $i;
		}
		for ($i = 0; $i < 5; $i++) {
			echo $i;
		}
	}

	public function definednessProvedByFlag(int $n): void
	{
		$found = false;
		for ($i = 0; $i < $n; $i++) {
			if ($i === 3) {
				$found = true;
				break;
			}
		}
		if (!$found) {
			return;
		}

		for ($i = 0; $i < $n; $i++) {
			echo $i;
		}
	}

	public function parameterNotReadAfterLoop(int $i): void
	{
		echo $i;
		for ($i = 0; $i < 10; $i++) {
			echo $i;
		}
	}

	public function freshVariableReadAfterLoop(): void
	{
		for ($i = 0; $i < 10; $i++) {
		}
		echo $i;
	}

	public function reassignedAfterLoop(int $i): void
	{
		for ($i = 0; $i < 10; $i++) {
		}
		$i = 5;
		echo $i;
	}

	public function parameterReadAfterLoop(int $i): void
	{
		for ($i = 0; $i < 10; $i++) {
		}
		echo $i;
	}

	public function loopVariableReadAfterSecondLoop(): void
	{
		for ($i = 0; $i < 10; $i++) {
		}
		for ($i = 0; $i < 5; $i++) {
		}
		echo $i;
	}

	public function outerLoopVariableClobbered(): void
	{
		for ($i = 0; $i < 10; $i++) {
			for ($i = 0; $i < 5; $i++) {
			}
			echo $i;
		}
	}

	/** @param array{int, int} $b */
	public function listTarget(int $i, int $j, array $b): void
	{
		for ([$i, $j] = $b; $i < 10; $i++) {
		}
		echo $i;
	}

}
