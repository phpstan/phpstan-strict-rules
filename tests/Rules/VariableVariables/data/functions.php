<?php // lint >= 8.1

function (callable $a, string $b) {
	time();
	$a();
	$b();
	$c = function () {};
	$c();
	$d = fn ($a) => $a;
	$d();
	$e = time(...);
	$e();
	$f = 'time';
	$f();
	$g = ['PDO', 'connect'];
	$g();
	$h = ['PDO', $b];
	$h();
};
