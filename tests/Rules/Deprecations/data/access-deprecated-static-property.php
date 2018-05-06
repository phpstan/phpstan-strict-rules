<?php

namespace AccessDeprecatedStaticProperty;

Foo::$foo = 'foo';
echo Foo::$foo;

Foo::$deprecatedFoo = 'foo';
echo Foo::$deprecatedFoo;

$foo = new Foo();

$foo::$foo = 'foo';
echo $foo::$foo;

$foo::$deprecatedFoo = 'foo';
echo $foo::$deprecatedFoo;

FooTrait::$fooFromTrait = 'foo';
echo FooTrait::$fooFromTrait;

FooTrait::$deprecatedFooFromTrait = 'foo';
echo FooTrait::$deprecatedFooFromTrait;

$foo = new Foo();

$foo::$fooFromTrait = 'foo';
echo $foo::$fooFromTrait;

$foo::$deprecatedFooFromTrait = 'foo';
echo $foo::$deprecatedFooFromTrait;

/**
 * @deprecated
 */
function deprecated_scope()
{
	Foo::$foo = 'foo';
	echo Foo::$foo;

	Foo::$deprecatedFoo = 'foo';
	echo Foo::$deprecatedFoo;

	$foo = new Foo();

	$foo::$foo = 'foo';
	echo $foo::$foo;

	$foo::$deprecatedFoo = 'foo';
	echo $foo::$deprecatedFoo;

	FooTrait::$fooFromTrait = 'foo';
	echo FooTrait::$fooFromTrait;

	FooTrait::$deprecatedFooFromTrait = 'foo';
	echo FooTrait::$deprecatedFooFromTrait;

	$foo = new Foo();

	$foo::$fooFromTrait = 'foo';
	echo $foo::$fooFromTrait;

	$foo::$deprecatedFooFromTrait = 'foo';
	echo $foo::$deprecatedFooFromTrait;
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	public function foo()
	{
		Foo::$foo = 'foo';
		echo Foo::$foo;

		Foo::$deprecatedFoo = 'foo';
		echo Foo::$deprecatedFoo;

		$foo = new Foo();

		$foo::$foo = 'foo';
		echo $foo::$foo;

		$foo::$deprecatedFoo = 'foo';
		echo $foo::$deprecatedFoo;

		FooTrait::$fooFromTrait = 'foo';
		echo FooTrait::$fooFromTrait;

		FooTrait::$deprecatedFooFromTrait = 'foo';
		echo FooTrait::$deprecatedFooFromTrait;

		$foo = new Foo();

		$foo::$fooFromTrait = 'foo';
		echo $foo::$fooFromTrait;

		$foo::$deprecatedFooFromTrait = 'foo';
		echo $foo::$deprecatedFooFromTrait;
	}

}
