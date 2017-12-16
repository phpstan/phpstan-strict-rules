<?php

namespace AccessDeprecatedProperty;

trait FooTrait
{

	public $fooFromTrait;

	/**
	 * @deprecated
	 */
	public $deprecatedFooFromTrait;

}

class Foo {

	use FooTrait;

	public $foo;

	/**
	 * @deprecated
	 */
	public $deprecatedFoo;

}
