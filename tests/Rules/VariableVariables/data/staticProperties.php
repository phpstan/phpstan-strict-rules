<?php

function (stdClass $std) {
	Foo::$fooProperty = 123;

	$bar = 'fooProperty';
	echo Foo::$$bar;
	Foo::$$bar = 123;

	echo Foo::${$bar};
	Foo::${$bar} = 123;

	$std::$$bar = 123;
};
