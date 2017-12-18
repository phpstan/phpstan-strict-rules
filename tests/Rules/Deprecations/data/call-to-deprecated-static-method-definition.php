<?php

namespace CheckDeprecatedStaticMethodCall;

class Foo
{

	public static function foo()
	{

	}

	/**
	 * @deprecated
	 */
	public static function deprecatedFoo()
	{

	}

	/**
	 * @deprecated
	 */
	public static function deprecatedFoo2()
	{

	}

}

class Bar extends Foo
{

	public static function deprecatedFoo()
	{

	}

}

/**
 * @deprecated
 */
class DeprecatedBar extends Foo
{

}
