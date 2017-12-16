<?php

namespace CheckDeprecatedMethodCall;

trait FooTrait
{

	public function fooFromTrait()
	{

	}

	/**
	 * @deprecated
	 */
	public function deprecatedFooFromTrait()
	{

	}

}

class Foo
{

	use FooTrait;

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
