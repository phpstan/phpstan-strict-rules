<?php

namespace Operators;

use stdClass;

$int = 123;
$float = 123.456;
$array = [];
$string = '123';
$object = new stdClass();
$null = null;

/** @var int|float $intOrFloat */
$intOrFloat = foo();

$int + $int;
$int + $float;
$float + $int;
$float + $float;
$int + $float + $int;
$intOrFloat + $int;
$array + $array;
$array + $array + $array;
$int + $string;
$int + $array;
$int + $object;
$int + $null;
$int + $float + $string + $null;
$array + $float + $array + $int;

$int - $int;
$int - $float;
$float - $int;
$float - $float;
$int - $float - $int;
$intOrFloat - $int;
$int - $string;
$int - $array;
$int - $object;
$int - $null;
$int - $float - $string - $null;
$array - $float - $array - $int;

$int * $int;
$int * $float;
$float * $int;
$float * $float;
$int * $float * $int;
$intOrFloat * $int;
$int * $string;
$int * $array;
$int * $object;
$int * $null;
$int * $float * $string * $null;
$array * $float * $array * $int;

$int / $int;
$int / $float;
$float / $int;
$float / $float;
$int / $float / $int;
$intOrFloat / $int;
$int / $string;
$int / $array;
$int / $object;
$int / $null;
$int / $float / $string / $null;
$array / $float / $array / $int;

$int ** $int;
$int ** $float;
$float ** $int;
$float ** $float;
$int ** $float ** $int;
$intOrFloat ** $int;
$int ** $string;
$int ** $array;
$int ** $object;
$int ** $null;
$int ** $float ** $string ** $null;
$array ** $float ** $array ** $int;

$int % $int;
$int % $float;
$float % $int;
$float % $float;
$int % $float % $int;
$intOrFloat % $int;
$int % $string;
$int % $array;
$int % $object;
$int % $null;
$int % $float % $string % $null;
$array % $float % $array % $int;

function ($mixed, int $a) {
	$mixed + $mixed;
	$mixed + $a;
	$a + $mixed;
};
