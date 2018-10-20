<?php

namespace Operators;

use stdClass;

$int = 123;
$float = 123.456;
$array = [];
$string = '123';
$object = new stdClass();
$null = null;
$date = new \DateTime("@123");
$dateImm = new \DateTimeImmutable("@123");

/** @var int|float $intOrFloat */
$intOrFloat = foo();

$int == $int;
$int == $float;
$float == $int;
$float == $float;
$intOrFloat == $int;
$array == $array;
$int == $string;
$int == $array;
$int == $object;
$int == $null;
$int == $date;
$date == $date;
$date == $dateImm;
$date == $int;
$date == $object;
$date == $null;

$int != $int;
$int != $float;
$float != $int;
$float != $float;
$intOrFloat != $int;
$int != $string;
$int != $array;
$int != $object;
$int != $null;
$int != $date;
$date != $date;
$date != $dateImm;
$date != $int;
$date != $object;
$date != $null;

$int <> $int;
$int <> $string;

$int < $int;
$int < $float;
$float < $int;
$float < $float;
$intOrFloat < $int;
$int < $string;
$int < $array;
$int < $object;
$int < $null;
$int < $date;
$date < $date;
$date < $dateImm;
$date < $int;
$date < $object;
$date < $null;

$int > $int;
$int > $float;
$float > $int;
$float > $float;
$intOrFloat > $int;
$int > $string;
$int > $array;
$int > $object;
$int > $null;
$int > $date;
$date > $date;
$date > $dateImm;
$date > $int;
$date > $object;
$date > $null;

$int <= $int;
$int <= $float;
$float <= $int;
$float <= $float;
$intOrFloat <= $int;
$int <= $string;
$int <= $array;
$int <= $object;
$int <= $null;
$int <= $date;
$date <= $date;
$date <= $dateImm;
$date <= $int;
$date <= $object;
$date <= $null;

$int >= $int;
$int >= $float;
$float >= $int;
$float >= $float;
$intOrFloat >= $int;
$int >= $string;
$int >= $array;
$int >= $object;
$int >= $null;
$int >= $date;
$date >= $date;
$date >= $dateImm;
$date >= $int;
$date >= $object;
$date >= $null;

$int <=> $int;
$int <=> $float;
$float <=> $int;
$float <=> $float;
$intOrFloat <=> $int;
$int <=> $string;
$int <=> $array;
$int <=> $object;
$int <=> $null;
$int <=> $date;
$date <=> $date;
$date <=> $dateImm;
$date <=> $int;
$date <=> $object;
$date <=> $null;

function ($mixed, int $a, string $b) {
	$mixed == $mixed;
	$mixed == $a;
	$a == $mixed;
	$mixed == $b;
	$b == $mixed;
};

function (array $array, int $int, $mixed) {
	foreach ($array as $i => $val) {
		$i == $int;
	}

	explode($mixed, $mixed) == $int;
};
