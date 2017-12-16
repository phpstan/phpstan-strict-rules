<?php

namespace CheckDeprecatedMethodCall;

$foo = new Foo();
$foo->foo();
$foo->deprecatedFoo();

$bar = new Bar();
$bar->deprecatedFoo();
$bar->deprecatedFoo2();

$foo->fooFromTrait();
$foo->deprecatedFooFromTrait();
