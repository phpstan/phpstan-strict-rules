<?php

function (stdClass $std) {
	$std->foo = 'test';
	$foo = 'bar';
	$std->$foo = 'foo';

	echo $std->foo;
	echo $std->$foo;
};
