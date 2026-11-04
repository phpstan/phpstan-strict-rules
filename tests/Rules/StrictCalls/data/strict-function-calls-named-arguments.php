<?php // lint >= 8.0

namespace StrictCallsNamedArguments;

/**
 * @param int<5, 10> $phpdocIntRange
 */
function doFoo(int $i, int $i2, $phpdocIntRange): void {
	in_array(needle: $i, haystack: [1, 2]);
	in_array(needle: $i, haystack: [1, 2], strict: false);
	in_array(strict: false, needle: $i, haystack: [1, 2]);
	in_array($i, haystack: [1, 2]);

	if ($i > 5 && $i < 10) {
		in_array($i, haystack: [1, 2]);
	}
	if ($i > 0) {
		in_array($i, haystack: [1, 2]);
	}
	if ($i2 > 0) {
		in_array($i, haystack: [1, $i2]);
	}

	in_array($i, haystack: [1, $phpdocIntRange]);
	in_array($phpdocIntRange, haystack: [1, 2]);
}

function doBar(int|string $union): void {
	in_array(needle: $union, haystack: [1, 2]);
}
