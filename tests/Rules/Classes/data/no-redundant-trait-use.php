<?php declare(strict_types = 1);

trait BarTrait
{

	public function barMethod(): void
	{
	}

}

trait FooTrait
{

	use BarTrait;

	public function fooMethod(): void
	{
	}

}

// This class uses both FooTrait and BarTrait, but BarTrait is already included via FooTrait
class RedundantTraitUseClass
{

	use FooTrait;
	use BarTrait; // This should trigger an error

}