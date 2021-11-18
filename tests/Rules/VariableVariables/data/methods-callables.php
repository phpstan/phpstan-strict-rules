<?php // lint >= 8.1

function (stdClass $std) {
	$std->foo(...);

	$foo = 'bar';
	$std->$foo(...);
};
