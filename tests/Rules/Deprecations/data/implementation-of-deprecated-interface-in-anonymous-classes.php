<?php

namespace ImplementationOfDeprecatedInterface;

$fooable = new class implements Fooable {

};

$fooable2 = new class implements DeprecatedFooable {

};

$fooable3 = new class implements Fooable, DeprecatedFooable, DeprecatedFooable2 {

};
