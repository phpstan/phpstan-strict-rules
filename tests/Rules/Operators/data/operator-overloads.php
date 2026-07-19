<?php

namespace OperatorOverloads;

use BcMath\Number;
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

function bcmathOperations(Number $bcmath, int $int): void
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

function mixedNumericOperations(GMP $gmp, Number $bcmath, int $int, float $float): void
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

function incompatibleOverloads(GMP $gmp, Number $bcmath): void
{
	$gmp + $bcmath;
	$bcmath + $gmp;
}
