<?php

function (stdClass $std) {
	Foo::doFoo();

	$foo = 'doBar';
	Foo::$foo();

	$std::$foo();
};
