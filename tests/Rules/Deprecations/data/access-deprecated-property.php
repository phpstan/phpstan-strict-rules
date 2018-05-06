<?php

namespace AccessDeprecatedProperty;

$foo = new Foo();

$foo->foo = 'foo';
$foo->foo;

$foo->deprecatedFoo = 'deprecatedFoo';
$foo->deprecatedFoo;

$foo->fooFromTrait = 'fooFromTrait';
$foo->fooFromTrait;

$foo->deprecatedFooFromTrait = 'deprecatedFooFromTrait';
$foo->deprecatedFooFromTrait;

/**
 * @deprecated
 */
function deprecated_scope()
{
	$foo = new Foo();

	$foo->foo = 'foo';
	$foo->foo;

	$foo->deprecatedFoo = 'deprecatedFoo';
	$foo->deprecatedFoo;

	$foo->fooFromTrait = 'fooFromTrait';
	$foo->fooFromTrait;

	$foo->deprecatedFooFromTrait = 'deprecatedFooFromTrait';
	$foo->deprecatedFooFromTrait;
}

/**
 * @deprecated
 */
class DeprecatedScope
{

	public function foo()
	{
		$foo = new Foo();

		$foo->foo = 'foo';
		$foo->foo;

		$foo->deprecatedFoo = 'deprecatedFoo';
		$foo->deprecatedFoo;

		$foo->fooFromTrait = 'fooFromTrait';
		$foo->fooFromTrait;

		$foo->deprecatedFooFromTrait = 'deprecatedFooFromTrait';
		$foo->deprecatedFooFromTrait;
	}

}
