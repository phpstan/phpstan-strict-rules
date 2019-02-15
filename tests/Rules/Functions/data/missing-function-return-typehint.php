<?php

namespace
{
	function globalFunction1($a, $b, $c)
	{
		return false;
	}

	function globalFunction2($a, $b, $c): bool
	{
		$closure = function($a, $b, $c) {

		};

		return false;
	}

	/**
	 * @return bool
	 */
	function globalFunction3($a, $b, $c)
	{
		return false;
	}

	function globalFunction4() : array
	{
	}

	function globalFunction5() : iterable
	{
	}

	function globalFunction6() : \ArrayObject
	{
	}
}

namespace MissingFunctionReturnTypehint
{
	function namespacedFunction1($d, $e)
	{
		return 9;
	};

	function namespacedFunction2($d, $e): int
	{
		return 9;
	};

	/**
	 * @return int
	 */
	function namespacedFunction3($d, $e)
	{
		return 9;
	};

	/**
	 * @return array<string>
	 */
	function namespacedFunction4() : array
	{
	}

	/**
	 * @return iterable<string>
	 */
	function namespacedFunction5() : iterable
	{
	}

	/**
	 * @return \ArrayObject<string>
	 */
	function namespacedFunction6() : \ArrayObject
	{
	}
}
