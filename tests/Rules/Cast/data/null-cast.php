<?php // lint >= 8.0

namespace NullCast;

function foo(?int $a, string $b, ?string $c, mixed $d) {
	(int)$a;
	(int)$b;
	(int)$c;
	(float)$a;
	(float)$b;
	(float)$c;
	(string)$c;
	(object)$c;
	(object)'null';
	(object)null;
	(array)'null';
	(array)null;
	(int)$d;
}
