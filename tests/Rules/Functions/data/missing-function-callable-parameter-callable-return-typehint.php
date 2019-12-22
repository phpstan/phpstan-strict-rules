<?php

namespace
{
	/**
	 * @param \Closure|callable $a
	 */
	function globalFunction($a, \Closure $b, callable $c): bool
	{
		$closure = function($a, $b, $c) {

		};

		return false;
	}
}

namespace MissingFunctionParameterTypehint
{
	/**
	 * @param $d
	 */
	function namespacedFunction($d, callable $e): int {
		return 9;
	};
}
