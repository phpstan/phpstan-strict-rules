<?php

namespace AccessDeprecatedProperty;

$foo = new Foo();

$foo->foo = 'foo';
echo $foo->foo;

$foo->deprecatedFoo = 'deprecatedFoo';
echo $foo->deprecatedFoo;
