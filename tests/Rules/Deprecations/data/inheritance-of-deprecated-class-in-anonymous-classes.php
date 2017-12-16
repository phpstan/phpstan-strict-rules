<?php

namespace InheritanceOfDeprecatedClass;

$foo = new class extends Foo {

};

$deprecatedFoo = new class extends DeprecatedFoo {

};
