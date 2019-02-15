<?php

namespace MissingMethodParameterTypehint;

interface FooInterface
{

	public function a1($p1, $p2, $p3);

	public function a2(array $p1);

	public function a3(iterable $p1);

	public function a4(\ArrayObject $p1);

}

class FooParent
{

	public function b1($p1)
	{
	}

	public function b2(array $p1)
	{
	}

	public function b3(iterable $p1)
	{
	}

	public function b4(\ArrayObject $p1)
	{
	}

}

trait FooTrait
{

	public function c1($p1)
	{
	}

	public function c2(array $p1)
	{
	}

	public function c3(iterable $p1)
	{
	}

	public function c4(\ArrayObject $p1)
	{
	}

}

class Foo extends FooParent implements FooInterface
{
	use FooTrait;

	/**
	 * @param resource $p1
	 * @param array $p2
	 */
	public function a1($p1, $p2, $p3)
	{
	}

	/**
	 * @param array<string> $p1
	 */
	public function a2(array $p1)
	{
	}

	/**
	 * @param iterable<string> $p1
	 */
	public function a3(iterable $p1)
	{
	}

	/**
	 * @param \ArrayObject<string> $p1
	 */
	public function a4(\ArrayObject $p1)
	{
	}

	/**
	 * @param resource $p1
	 */
	public function b1($p1)
	{
	}

	/**
	 * @param array<string> $p1
	 */
	public function b2(array $p1)
	{
	}

	/**
	 * @param iterable<string> $p1
	 */
	public function b3(iterable $p1)
	{
	}

	/**
	 * @param \ArrayObject<string> $p1
	 */
	public function b4(\ArrayObject $p1)
	{
	}

}

class SubFoo extends Foo
{

	/**
	 * @param resource $p1
	 * @param array<string> $p2
	 * @param mixed $p3
	 */
	public function a1($p1, $p2, $p3)
	{
	}

	public function a2(array $p1)
	{
	}

	public function a3(iterable $p1)
	{
	}

	public function a4(\ArrayObject $p1)
	{
	}

	public function b1($p1)
	{
	}

	public function b2(array $p1)
	{
	}

	public function b3(iterable $p1)
	{
	}

	public function b4(\ArrayObject $p1)
	{
	}

	/**
	 * @param resource $p1
	 */
	public function c1($p1)
	{
	}

	/**
	 * @param array<string> $p1
	 */
	public function c2(array $p1)
	{
	}

	/**
	 * @param iterable<string> $p1
	 */
	public function c3(iterable $p1)
	{
	}

	/**
	 * @param \ArrayObject<string> $p1
	 */
	public function c4(\ArrayObject $p1)
	{
	}

}
