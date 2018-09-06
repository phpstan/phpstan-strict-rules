<?php

namespace MissingArrayValueTypeInMethodParameter;

interface FooInterface
{

	/**
	 * @param array $p1
	 */
    public function getFoo($p1): void;

}

class FooParent
{

    public function getBar(array $p2)
    {

    }

}

class Foo extends FooParent implements FooInterface
{

	/**
	 * @param array<int, array<string, array<int|string, mixed>>> $p1
	 */
    public function getFoo($p1): void
    {

    }

    /**
     * @param $p2
     */
    public function getBar(array $p2)
    {

    }

    /**
     * @param array<mixed> $p3
     */
    public function getBaz($p3, $p4): bool
    {
        return false;
    }

    /**
     * @param mixed[] $p5
     */
    public function getFooBar(array $p5): bool
    {
        return false;
    }

}
