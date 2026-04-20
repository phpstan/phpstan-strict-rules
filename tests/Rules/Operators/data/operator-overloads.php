<?php

namespace OperatorOverloads;

use GMP;

function gmpOperations(GMP $gmp, int $int): void
{
	$gmp + $int;
	$gmp - $int;
	$gmp * $int;
	$gmp / $int;
	$gmp % $int;
	$gmp ** $int;

	$int + $gmp;
	$int - $gmp;
	$int * $gmp;
	$int / $gmp;
	$int % $gmp;
	$int ** $gmp;

	$gmp + $gmp;
	$gmp - $gmp;
	$gmp * $gmp;
	$gmp / $gmp;
	$gmp % $gmp;
	$gmp ** $gmp;

	+$gmp;
	-$gmp;

	$gmp += $int;
	$gmp -= $int;
	$gmp *= $int;
	$gmp /= $int;
	$gmp %= $int;
	$gmp **= $int;
}

/**
 * @param \BcMath\Number $bcmath
 */
function bcmathOperations($bcmath, int $int): void
{
	$bcmath + $int;
	$bcmath - $int;
	$bcmath * $int;
	$bcmath / $int;
	$bcmath % $int;
	$bcmath ** $int;

	$int + $bcmath;
	$int - $bcmath;
	$int * $bcmath;
	$int / $bcmath;
	$int % $bcmath;
	$int ** $bcmath;

	$bcmath + $bcmath;
	$bcmath - $bcmath;
	$bcmath * $bcmath;
	$bcmath / $bcmath;
	$bcmath % $bcmath;
	$bcmath ** $bcmath;

	+$bcmath;
	-$bcmath;

	$bcmath += $int;
	$bcmath -= $int;
	$bcmath *= $int;
	$bcmath /= $int;
	$bcmath %= $int;
	$bcmath **= $int;
}

/**
 * @param \BcMath\Number $bcmath
 */
function mixedNumericOperations(GMP $gmp, $bcmath, int $int, float $float): void
{
	$gmp + $float;
	$gmp - $float;
	$gmp * $float;
	$gmp / $float;

	$bcmath + $float;
	$bcmath - $float;
	$bcmath * $float;
	$bcmath / $float;
}
