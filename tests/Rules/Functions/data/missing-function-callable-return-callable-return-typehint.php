<?php

namespace
{
	function globalFunction1($a, $b, $c): callable
	{
		return function() {};
	}

	function globalFunction2($a, $b, $c): bool
	{
		$closure = function($a, $b, $c) {

		};

		return false;
	}

	/**
	 * @return callable(): void
	 */
	function globalFunction3($a, $b, $c)
	{
		return function(): void {};
	}
}

namespace MissingFunctionReturnTypehint
{
	/**
	 * @return callable
	 */
	function namespacedFunction1($d, $e)
	{
		return function() {};
	};

	function namespacedFunction2($d, $e)
	{
		return function() {};
	};

	function namespacedFunction3($d, $e)
	{
		return function() {};
	};
}
