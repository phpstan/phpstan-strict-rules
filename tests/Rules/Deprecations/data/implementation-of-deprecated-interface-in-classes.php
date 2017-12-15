<?php

namespace ImplementationOfDeprecatedInterface;

class Foo implements Fooable
{

}

class Foo2 implements DeprecatedFooable
{

}

class Foo3 implements Fooable, DeprecatedFooable, DeprecatedFooable2
{

}
