<?php

namespace CheckDeprecatedStaticMethodCall;

Foo::foo();
Foo::deprecatedFoo();

Bar::deprecatedFoo();
Bar::deprecatedFoo2();

DeprecatedBar::foo();
DeprecatedBar::deprecatedFoo();
DeprecatedBar::deprecatedFoo2();

class Bar2 extends Foo
{

	public static function deprecatedFoo()
	{
		parent::foo();
		parent::deprecatedFoo();
	}

}

/**
 * @deprecated
 */
function deprecated_scope()
{
	Foo::foo();
	Foo::deprecatedFoo();
	Foo::deprecatedFoo2();
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	public static function foo()
	{
		Foo::foo();
		Foo::deprecatedFoo();
		Foo::deprecatedFoo2();
	}

}
