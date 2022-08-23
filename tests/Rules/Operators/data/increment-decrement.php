<?php

namespace Operators;

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

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union): void {
	$int--;
	$float--;
	$bool--;
	$string--;
	$null--;
	$object--;
	$mixed--;
	$union--;
})();

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union): void {
	$int++;
	$float++;
	$bool++;
	$string++;
	$null++;
	$object++;
	$mixed++;
	$union++;
})();

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union): void {
	--$int;
	--$float;
	--$bool;
	--$string;
	--$null;
	--$object;
	--$mixed;
	--$union;
})();

(function () use ($int, $float, $bool, $string, $null, $object, $mixed, $union): void {
	++$int;
	++$float;
	++$bool;
	++$string;
	++$null;
	++$object;
	++$mixed;
	++$union;
})();


function (): void {
	for ($i = 5; $i < 4; $i++) {
	}

	for ($y = 0; $y < 0; $y++) {
	}
};
