<?php // lint >= 8.2

namespace StrictCallsNamedArgumentsFollowedByPositional;

use function in_array;

function doFoo(int $i): void
{
	// named argument followed by positional ones
	in_array(needle: $i, haystack: [1, 2], false);
}
