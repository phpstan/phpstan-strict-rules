<?php

function (stdClass $std) {
	$std->foo();

	$foo = 'bar';
	$std->$foo();
};
