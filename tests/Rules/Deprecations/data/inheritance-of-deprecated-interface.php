<?php

namespace InheritanceOfDeprecatedInterface;

interface Foo extends Fooable
{

}

interface Foo2 extends DeprecatedFooable
{

}

interface Foo3 extends Fooable, DeprecatedFooable, DeprecatedFooable2
{

}

/**
 * @deprecated
 */
interface DeprecatedFoo extends Fooable
{

}

/**
 * @deprecated
 */
interface DeprecatedFoo2 extends DeprecatedFooable
{

}

/**
 * @deprecated
 */
interface DeprecatedFoo3 extends Fooable, DeprecatedFooable, DeprecatedFooable2
{

}
