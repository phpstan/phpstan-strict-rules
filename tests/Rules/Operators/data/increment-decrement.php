<?php

namespace Operators;

use BcMath\Number;
use GMP;
use stdClass;

$int = 123;
$float = 123.456;
$bool = false;
$string = 'abc';
$null = null;
$object = new stdClass();
/** @var mixed $mixed */
$mixed = foo();
/** @var int|string|stdClass $union */
$union = bar();
$gmp = new GMP('1');
$bcmath = new BCMath\Number('2');

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union, $gmp, $bcmath): void {
	$int--;
	$float--;
	$bool--;
	$string--;
	$null--;
	$object--;
	$mixed--;
	$union--;
	$gmp--;
	$bcmath--;
})();

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union, $gmp, $bcmath): void {
	$int++;
	$float++;
	$bool++;
	$string++;
	$null++;
	$object++;
	$mixed++;
	$union++;
	$gmp++;
	$bcmath++;
})();

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union, $gmp, $bcmath): void {
	--$int;
	--$float;
	--$bool;
	--$string;
	--$null;
	--$object;
	--$mixed;
	--$union;
	--$gmp;
	--$bcmath;
})();

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union, $gmp, $bcmath): void {
	++$int;
	++$float;
	++$bool;
	++$string;
	++$null;
	++$object;
	++$mixed;
	++$union;
	++$gmp;
	++$bcmath;
})();


function (): void {
	for ($i = 5; $i < 4; $i++) {
	}

	for ($y = 0; $y < 0; $y++) {
	}
};
