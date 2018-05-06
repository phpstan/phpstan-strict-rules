<?php

namespace FetchingClassConstOfDeprecatedClass;

echo Foo::class;
echo DeprecatedFoo::class;

/**
 * @deprecated
 */
function deprecated_scope()
{
	echo Foo::class;
	echo DeprecatedFoo::class;
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	function foo()
	{
		echo Foo::class;
		echo DeprecatedFoo::class;
	}

}
