<?php

namespace MissingMethodIterableReturnTypehint;

interface FooInterface
{

	public function a1(): array;

	/**
	 * @return array
	 */
	public function a2();

	/**
	 * @return array<string>
	 */
	public function a3(): array;

	/**
	 * @return string[]
	 */
	public function a4(): array;

	/**
	 * @return string|array|\ArrayObject<string>
	 */
	public function a5();

	public function a6();

	public function a7(): string;

}

class FooParent
{

	public function b1(): iterable
	{

	}

	/**
	 * @return iterable
	 */
	public function b2()
	{

	}

	/**
	 * @return iterable<string>
	 */
	public function b3(): iterable
	{

	}

	/**
	 * @return string[]
	 */
	public function b4(): iterable
	{

	}

	/**
	 * @return string|iterable|\ArrayObject<string>
	 */
	public function b5()
	{

	}

	public function b6()
	{

	}

	public function b7(): string
	{

	}

}

trait FooTrait
{

	public function c1(): \ArrayObject
	{

	}

	/**
	 * @return \ArrayObject
	 */
	public function c2()
	{

	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function c3(): \ArrayObject
	{

	}

	/**
	 * @return \ArrayObject|string[]
	 */
	public function c4()
	{

	}

	/**
	 * @return string|\ArrayObject|array<string>
	 */
	public function c5()
	{

	}

	public function c6()
	{

	}

	public function c7(): string
	{

	}

}

class Foo extends FooParent implements FooInterface
{
	use FooTrait;

	public function a1(): array
	{
	}

	public function a2()
	{
	}

	public function a3(): array
	{
	}

	public function a4(): array
	{
	}

	public function a5()
	{
	}

	public function a6()
	{
	}

	public function a7(): string
	{
	}

	public function b1(): iterable
	{

	}

	public function b2()
	{

	}

	public function b3(): iterable
	{

	}

	public function b4(): iterable
	{

	}

	public function b5()
	{

	}

	public function b6()
	{
	}

	public function b7(): string
	{
	}

	public function c1(): \ArrayObject
	{

	}

	public function c2(): \ArrayObject
	{

	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function c3(): \ArrayObject
	{

	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function c4(): \ArrayObject
	{

	}

	/**
	 * @return string|\ArrayObject|array<string>
	 */
	public function c5()
	{

	}

	public function c6()
	{
	}

	public function c7(): string
	{
	}

}

class SubFoo extends FooParent
{

	/**
	 * @return array<string>
	 */
	public function a1(): array
	{
	}

	/**
	 * @return array<string>
	 */
	public function a2()
	{
	}

	/**
	 * @return array
	 */
	public function a3(): array
	{
	}

	/**
	 * @return array
	 */
	public function a4(): array
	{
	}

	/**
	 * @return string|array<string>|\ArrayObject<string>
	 */
	public function a5()
	{
	}

	public function a6()
	{
	}

	public function a7(): string
	{
	}

	/**
	 * @return iterable<string>
	 */
	public function b1(): iterable
	{

	}

	/**
	 * @return iterable<string>
	 */
	public function b2()
	{

	}

	/**
	 * @return iterable
	 */
	public function b3(): iterable
	{

	}

	/**
	 * @return iterable
	 */
	public function b4(): iterable
	{

	}

	/**
	 * @return string|iterable<string>|\ArrayObject<string>
	 */
	public function b5()
	{

	}

	public function b6()
	{
	}

	public function b7(): string
	{
	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function c1(): \ArrayObject
	{

	}

	/**
	 * @return \ArrayObject<string>
	 */
	public function c2()
	{

	}

	/**
	 * @return \ArrayObject
	 */
	public function c3(): \ArrayObject
	{

	}

	/**
	 * @return \ArrayObject
	 */
	public function c4()
	{

	}

	/**
	 * @return string|\ArrayObject<string>|array<string>
	 */
	public function c5()
	{

	}

	public function c6()
	{
	}

	public function c7(): string
	{
	}

}
