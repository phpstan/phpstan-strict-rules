<?php

namespace MissingMethodReturnCallableReturnTypehint;

interface FooInterface
{

    public function getFoo($p1): callable;

}

class FooParent
{

    public function getBar($p2)
    {

    }

}

class Foo extends FooParent implements FooInterface
{

    public function getFoo($p1): callable
    {
	    return function() {};
    }

    public function getBar($p2)
    {

    }

	/**
	 * @return callable(): void
	 */
    public function getBaz(): callable
    {
        return function(): void {};
    }

}
