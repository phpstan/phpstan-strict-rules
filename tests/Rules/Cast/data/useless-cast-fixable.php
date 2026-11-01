<?php declare(strict_types = 1);

namespace UselessCastFixable;

use stdClass;

/**
 * @param bool $phpDocBoolean
 * @param int $phpDocInteger
 * @param float $phpDocFloat
 * @param string $phpDocString
 * @param array<int> $phpDocArray
 * @param stdClass $phpDocObject
 * @param non-empty-string $string
 */
function casts(
	bool $boolean,
	int $integer,
	float $float,
	string $string,
	array $array,
	stdClass $object,
	?int $nullableInteger,
	$phpDocBoolean,
	$phpDocInteger,
	$phpDocFloat,
	$phpDocString,
	$phpDocArray,
	$phpDocObject,
	$mixed
): void
{
	(bool) $boolean;
	(int) $integer;
	(float) $float;
	(string) $string;
	(array) $array;
	(object) $object;

	(bool) $phpDocBoolean;
	(int) $phpDocInteger;
	(float) $phpDocFloat;
	(string) $phpDocString;
	(array) $phpDocArray;
	(object) $phpDocObject;

	(string) $integer;
	(int) $nullableInteger;
	(int) $mixed;

	if ($nullableInteger !== null) {
		(int) $nullableInteger;
	}
	if (is_int($mixed)) {
		(int) $mixed;
	}

	(int) 42;
	(bool) true;
	(string) 'value';
	(array) [1, 2];
	(object) new stdClass();
	(int) ($integer + 1) * 2;
	2 - (int) ($integer + 1);
	(bool) ($boolean || true) && false;
	(int) ($integer = 1) + 2;
	(int) ($integer + 1) ** 2;
	(int) ($boolean ? $integer : 0);
	(int) ++$integer;
	(int) strlen($string);
}

class Foo
{
	public static function bug(string $key): void
	{
		$a = [$key => 1];

		foreach ($a as $k => $v) {
			$l = strlen((string)$k); // type cast is needed for auto-coerced non-decimal-int-string
		}
	}
}

// https://3v4l.org/krTct#v
function doFoo() {
	$array = [0, 1];
	foreach ((array) $array as &$v) {
		$v=2;
	}
	var_dump($array);
}
function doBar() {
	$array = [0, 1];
	foreach ($array as &$v) {
		$v=2;
	}
	var_dump($array);
}
doFoo();
doBar();

class X {
	public int $i;
	public string $s;
}

function doBaz(X $x) {
	echo (int) $x->i;
	echo (int) $x->s;

	echo (string) $x->i;
	echo (string) $x->s;
}
