<?php

namespace AccessDeprecatedProperty;

$foo = new Foo();

$foo->foo = 'foo';
echo $foo->foo;

$foo->deprecatedFoo = 'deprecatedFoo';
echo $foo->deprecatedFoo;

$foo->fooFromTrait = 'fooFromTrait';
echo $foo->fooFromTrait;

$foo->deprecatedFooFromTrait = 'deprecatedFooFromTrait';
echo $foo->deprecatedFooFromTrait;

