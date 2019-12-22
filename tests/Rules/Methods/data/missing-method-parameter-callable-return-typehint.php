<?php

namespace MissingMethodParameterCallableReturnTypehint;

interface FooInterface
{

	/**
	 * @param callable $p1
	 */
    public function getFoo($p1): void;

}

class FooParent
{

	/**
	 * @param callable $p2
	 */
    public function getBar($p2)
    {

    }

}

class Foo extends FooParent implements FooInterface
{

	/**
	 * @param callable $p1
	 */
    public function getFoo($p1): void
    {

    }

    /**
     * @param callable $p2
     */
    public function getBar($p2)
    {

    }

    /**
     * @param callable(): void $p3
     * @param callable $p4
     */
    public function getBaz($p3, $p4): bool
    {
        return false;
    }

    /**
     * @param callable(): mixed $p5
     */
    public function getFooBar($p5): bool
    {
        return false;
    }

}
