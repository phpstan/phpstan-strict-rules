<?php

namespace FetchingClassConstOfDeprecatedClass;

Foo::class;
DeprecatedFoo::class;

Foo::FOO;
Foo::DEPRECATED_FOO;

DeprecatedFoo::class;
DeprecatedFoo::class;

/**
 * @deprecated
 */
function deprecated_scope()
{
	Foo::class;
	DeprecatedFoo::class;
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	function foo()
	{
		Foo::class;
		DeprecatedFoo::class;
	}

}
