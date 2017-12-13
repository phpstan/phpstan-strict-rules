<?php

namespace CheckDeprecatedMethodCall;

class Foo {

	public function foo()
	{
	}

	/**
	 * @deprecated
	 */
	public function deprecatedFoo()
	{
	}

	/**
	 * @deprecated
	 */
	public function deprecatedFoo2()
	{
	}

}

class Bar extends Foo
{

	public function deprecatedFoo()
	{
	}

}

