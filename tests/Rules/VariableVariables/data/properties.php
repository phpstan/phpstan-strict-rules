<?php

namespace VariablePropertyFetch;

use stdClass;

class Foo
{

}

class Bar extends stdClass
{

}

function (stdClass $std, Foo $foo, Bar $bar) {
	$str = 'str';

	$std->foo;
	$std->$str;

	$foo->foo;
	$foo->$str;

	$bar->foo;
	$bar->$str;
};
