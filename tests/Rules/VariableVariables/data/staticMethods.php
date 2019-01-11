<?php

function () {
	Foo::doFoo();

	$foo = 'doBar';
	Foo::$foo();
};
