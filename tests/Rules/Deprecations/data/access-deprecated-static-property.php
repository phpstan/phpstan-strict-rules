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
