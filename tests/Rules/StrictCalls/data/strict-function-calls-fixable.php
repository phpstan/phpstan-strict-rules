<?php

namespace StrictCalls;

function searchBool(bool $bool) {
    array_search(false, [$bool]);
}

in_array(1, [1, 2]);
in_array(1, [1, 2], false);
array_keys([1, 2], 1);
$strict = rand(0, 1) === 1;
array_keys([1, 2], 1, $strict);
in_array(1, [1.0]);
in_array(1, [1.0], false);
in_array(1, [1, 1.0]);
in_array('1', ['01']);

$float = 1.0;
in_array($float, [1.0]);
in_array(null, [null]);

/** @return int[] */
function getArray(): array
{
	return [1, 2];
}

function doFoo(int $i): bool
{
	return in_array($i, getArray());
}

array_keys([1, 2]);
base64_decode('abcd');

$numericStringNeedle = '01'; // edge case: numeric string compared against int-string: https://3v4l.org/hmgdd#v
in_array($numericStringNeedle, ['1', '2']);

$stringNeedle = 'foo';
$strings = ['foo', 'bar'];
in_array($stringNeedle, $strings);
in_array($stringNeedle, $strings, false);
array_search($stringNeedle, $strings);
array_keys($strings, $stringNeedle);

/** @return string[] */
function getStringArray(): array
{
	return ['foo', 'bar'];
}

function doStringFoo(string $needle): bool
{
	return in_array($needle, getStringArray());
}

function doLiteralStringFoo(string $needle): bool
{
	return in_array($needle, ['foo', 'bar']);
}

class X {
	private const TYPES = [128, 256];
	private const TYPE_STRINGS = ['ABC', 'DEF'];
	private const TYPES_NUMERIC_STRING = ['ABC', 'DEF', '1'];

	function doFoo(int $i, string $s) {
		in_array($i, self::TYPES);
		in_array($s, self::TYPE_STRINGS);
		in_array($s, self::TYPES_NUMERIC_STRING);
	}
}
