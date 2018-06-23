<?php

namespace InheritanceOfDeprecatedClass;

$foo = new class extends Foo {

};

$deprecatedFoo = new class extends DeprecatedFoo {

};

/**
 * @deprecated
 */
function deprecated_scope()
{
	$foo = new class extends Foo {

	};

	$deprecatedFoo = new class extends DeprecatedFoo {

	};
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	public function foo()
	{
		$foo = new class extends Foo {

		};

		$deprecatedFoo = new class extends DeprecatedFoo {

		};
	}

}
