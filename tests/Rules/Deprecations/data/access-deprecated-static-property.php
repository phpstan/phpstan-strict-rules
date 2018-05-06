<?php

namespace AccessDeprecatedStaticProperty;

Foo::$foo = 'foo';
Foo::$foo;

Foo::$deprecatedFoo = 'foo';
Foo::$deprecatedFoo;

$foo = new Foo();

$foo::$foo = 'foo';
$foo::$foo;

$foo::$deprecatedFoo = 'foo';
$foo::$deprecatedFoo;

FooTrait::$fooFromTrait = 'foo';
FooTrait::$fooFromTrait;

FooTrait::$deprecatedFooFromTrait = 'foo';
FooTrait::$deprecatedFooFromTrait;

$foo = new Foo();

$foo::$fooFromTrait = 'foo';
$foo::$fooFromTrait;

$foo::$deprecatedFooFromTrait = 'foo';
$foo::$deprecatedFooFromTrait;

/**
 * @deprecated
 */
function deprecated_scope()
{
	Foo::$foo = 'foo';
	Foo::$foo;

	Foo::$deprecatedFoo = 'foo';
	Foo::$deprecatedFoo;

	$foo = new Foo();

	$foo::$foo = 'foo';
	$foo::$foo;

	$foo::$deprecatedFoo = 'foo';
	$foo::$deprecatedFoo;

	FooTrait::$fooFromTrait = 'foo';
	FooTrait::$fooFromTrait;

	FooTrait::$deprecatedFooFromTrait = 'foo';
	FooTrait::$deprecatedFooFromTrait;

	$foo = new Foo();

	$foo::$fooFromTrait = 'foo';
	$foo::$fooFromTrait;

	$foo::$deprecatedFooFromTrait = 'foo';
	$foo::$deprecatedFooFromTrait;
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	public function foo()
	{
		Foo::$foo = 'foo';
		Foo::$foo;

		Foo::$deprecatedFoo = 'foo';
		Foo::$deprecatedFoo;

		$foo = new Foo();

		$foo::$foo = 'foo';
		$foo::$foo;

		$foo::$deprecatedFoo = 'foo';
		$foo::$deprecatedFoo;

		FooTrait::$fooFromTrait = 'foo';
		FooTrait::$fooFromTrait;

		FooTrait::$deprecatedFooFromTrait = 'foo';
		FooTrait::$deprecatedFooFromTrait;

		$foo = new Foo();

		$foo::$fooFromTrait = 'foo';
		$foo::$fooFromTrait;

		$foo::$deprecatedFooFromTrait = 'foo';
		$foo::$deprecatedFooFromTrait;
	}

}
