<?php declare(strict_types = 1);

trait IndependentTrait1
{

	public function method1(): void
	{
	}

}

trait IndependentTrait2
{

	public function method2(): void
	{
	}

}

// This class uses two independent traits - this is valid
class ValidTraitUseClass
{

	use IndependentTrait1;
	use IndependentTrait2;

}