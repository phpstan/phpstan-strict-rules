<?php declare(strict_types = 1);

trait SingleTrait
{

	public function singleMethod(): void
	{
	}

}

// This class uses only one trait - this is valid (no redundancy possible)
class SingleTraitUseClass
{

	use SingleTrait;

}
