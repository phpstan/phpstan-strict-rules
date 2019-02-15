<?php

namespace
{
	/**
	 * @param int $a
	 * @param $b
	 */
	function globalFunction7($a, $b, $c): bool
	{
		$closure = function($a, $b, $c) {

		};

		return false;
	}

	function globalFunction8(array $a, iterable $b, \ArrayObject $c): bool
	{
	}

	/**
	 * @param array $a
	 * @param iterable $b
	 * @param \ArrayObject $c
	 */
	function globalFunction9($a, $b, $c): bool
	{
	}
}

namespace MissingFunctionParameterTypehint
{
	/**
	 * @param $d
	 */
	function namespacedFunction1($d, bool $e): int {
		return 9;
	};

	/**
	 * @param array<string> $a
	 * @param iterable<string> $b
	 * @param \ArrayObject<string> $c
	 */
	function namespacedFunction2(array $a, iterable $b, \ArrayObject $c): bool
	{
	}

	/**
	 * @param array<string> $a
	 * @param iterable<string> $b
	 * @param \ArrayObject<string> $c
	 */
	function namespacedFunction3($a, $b, $c): bool
	{
	}
}
