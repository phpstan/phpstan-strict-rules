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

/**
 * @deprecated
 */
class DeprecatedFoo implements Fooable
{

}

/**
 * @deprecated
 */
class DeprecatedFoo2 implements DeprecatedFooable
{

}

/**
 * @deprecated
 */
class DeprecatedFoo3 implements Fooable, DeprecatedFooable, DeprecatedFooable2
{

}
