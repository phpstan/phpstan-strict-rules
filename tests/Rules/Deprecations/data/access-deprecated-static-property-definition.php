<?php

namespace AccessDeprecatedStaticProperty;

class Foo {

	public static $foo;

	/**
	 * @deprecated
	 */
	public static $deprecatedFoo;

}
