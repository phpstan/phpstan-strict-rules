<?php declare(strict_types = 1);

trait BaseTrait
{

	public function baseMethod(): void
	{
	}

}

trait WrapperTrait
{

	use BaseTrait;

	public function wrapperMethod(): void
	{
	}

}

// This class uses WrapperTrait and BaseTrait, but BaseTrait is already included via WrapperTrait
class TransitiveRedundantTraitUseClass
{

	use WrapperTrait;
	use BaseTrait; // This should trigger an error (transitive redundancy)

}