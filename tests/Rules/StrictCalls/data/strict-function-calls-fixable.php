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

$numericStringNeedle = '01'; // edge case: numeric string compared against int-string
in_array($numericStringNeedle, ['1', '2']);
