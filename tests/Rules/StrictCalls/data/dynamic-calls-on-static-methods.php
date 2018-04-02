<?php declare(strict_types = 1);

namespace StrictCalls;

class ClassWithStaticMethod
{

	public static function foo(): void
	{
	}

	public function bar(): void
	{
		$this->foo();
		$this->bar();
	}

}

function (): void {
	$classWithStaticMethod = new ClassWithStaticMethod();
	$classWithStaticMethod->foo();
	$classWithStaticMethod->bar();
};

trait TraitWithStaticMethod
{

	public static function foo(): void
	{
	}

	public function bar(): void
	{
		$this->foo();
		$this->bar();
	}

}

class ClassUsingTrait
{

	use TraitWithStaticMethod;

}

function (): void {
	$classUsingTrait = new ClassUsingTrait();
	$classUsingTrait->foo();
	$classUsingTrait->bar();
};
