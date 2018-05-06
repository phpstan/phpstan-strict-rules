<?php

namespace ImplementationOfDeprecatedInterface;

$fooable = new class implements Fooable {

};

$fooable2 = new class implements DeprecatedFooable {

};

$fooable3 = new class implements Fooable, DeprecatedFooable, DeprecatedFooable2 {

};

/**
 * @deprecated
 */
function deprecated_scope()
{
	$fooable = new class implements Fooable {

	};

	$fooable2 = new class implements DeprecatedFooable {

	};

	$fooable3 = new class implements Fooable, DeprecatedFooable, DeprecatedFooable2 {

	};
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	public function foo()
	{
		$fooable = new class implements Fooable {

		};

		$fooable2 = new class implements DeprecatedFooable {

		};

		$fooable3 = new class implements Fooable, DeprecatedFooable, DeprecatedFooable2 {

		};
	}

}
