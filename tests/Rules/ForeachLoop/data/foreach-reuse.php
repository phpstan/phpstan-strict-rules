<?php

namespace OverwriteVariablesWithForeachReuse;

class Foo
{

	/**
	 * @param string[] $a
	 * @param string[] $b
	 */
	public function sequentialLoops(array $a, array $b): void
	{
		foreach ($a as $x) {
			echo $x;
		}
		foreach ($b as $x) {
			echo $x;
		}
		foreach ($b as $k => $x) {
			echo $k, $x;
		}
		foreach ($b as $k => $x) {
			echo $k, $x;
		}
	}

	/**
	 * @param string[] $catches
	 * @param string[] $exceptions
	 */
	public function definednessProvedByFlag(array $catches, array $exceptions): void
	{
		$hasGeneralCatch = false;
		foreach ($catches as $catch) {
			if ($catch === 'x') {
				$hasGeneralCatch = true;
				break;
			}
		}
		if (!$hasGeneralCatch) {
			return;
		}

		foreach ($exceptions as $exception) {
			foreach ($catches as $catch) {
				echo $exception, $catch;
			}
		}
	}

	/** @param string[] $a */
	public function notReadAfterLoop(array $a, string $x): void
	{
		echo $x;
		foreach ($a as $x) {
			echo $x;
		}
	}

	/** @param string[] $a */
	public function freshVariableReadAfterLoop(array $a): void
	{
		foreach ($a as $x) {
		}
		echo $x;
	}

	/** @param string[] $a */
	public function reassignedAfterLoop(array $a, string $x): void
	{
		echo $x;
		foreach ($a as $x) {
		}
		$x = 'other';
		echo $x;
	}

	/**
	 * @param string[] $outer
	 * @param string[] $inner
	 */
	public function outerLoopVariableClobbered(array $outer, array $inner): void
	{
		foreach ($outer as $x) {
			foreach ($inner as $x) {
				echo $x;
			}
			echo $x;
		}
	}

	/** @param string[] $a */
	public function conditionallyAssignedBeforeLoop(array $a, bool $c): void
	{
		if ($c) {
			$x = 'default';
		}
		foreach ($a as $x) {
		}
		echo $x;
	}

	/** @param string[] $a */
	public function readInLaterIterationOfOuterLoop(array $outer, array $a): void
	{
		$x = 'initial';
		foreach ($outer as $o) {
			echo $o, $x;
			foreach ($a as $x) {
			}
		}
	}

}
