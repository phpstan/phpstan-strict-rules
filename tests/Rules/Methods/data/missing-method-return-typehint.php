<?php

namespace MissingMethodReturnTypehint;

interface FooInterface
{

	public function a1($p1);

	public function a2($p1): array;

	public function a3($p1): iterable;

	public function a4($p1): \ArrayObject;

}

class FooParent
{

	public function b1($p1)
	{
	}

	public function b2($p1): array
	{
	}

	public function b3($p1): iterable
	{
	}

	public function b4($p1): \ArrayObject
	{
	}

}

trait FooTrait
{

	public function c1($p1)
	{
	}

	public function c2($p1): array
	{
	}

	public function c3($p1): iterable
	{
	}

	public function c4($p1): \ArrayObject
	{
	}

}

class Foo extends FooParent implements FooInterface
{
	use FooTrait;

	/**
	 * @return resource
	 */
	public function a1($p1)
	{
	}

	/**
	 * @return array<string>
	 */
	public function a2($p1): array
	{
	}

	/**
	 * @return iterable<string>
	 */
	public function a3($p1): iterable
	{
	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function a4($p1): \ArrayObject
	{
	}

	/**
	 * @return resource
	 */
	public function b1($p1)
	{
	}

	/**
	 * @return array<string>
	 */
	public function b2($p1): array
	{
	}

	/**
	 * @return iterable<string>
	 */
	public function b3($p1): iterable
	{
	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function b4($p1): \ArrayObject
	{
	}

}

class SubFoo extends Foo
{

	public function a1($p1)
	{
	}

	public function a2($p1): array
	{
	}

	public function a3($p1): iterable
	{
	}

	public function a4($p1): \ArrayObject
	{
	}

	public function b1($p1)
	{
	}

	public function b2($p1): array
	{
	}

	public function b3($p1): iterable
	{
	}

	public function b4($p1): \ArrayObject
	{
	}

	/**
	 * @return resource
	 */
	public function c1($p1)
	{
	}

	/**
	 * @return array<string>
	 */
	public function c2($p1): array
	{
	}

	/**
	 * @return iterable<string>
	 */
	public function c3($p1): iterable
	{
	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function c4($p1): \ArrayObject
	{
	}

}
