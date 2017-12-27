<?php

namespace StrictCalls;

class ClassWithStaticMethod
{
	public static function foo()
	{

	}

	public function bar()
	{
		$this->foo();
	}
}

function () {
	$classWithStaticMethod = new ClassWithStaticMethod();
	$classWithStaticMethod->foo();
};

trait TraitWithStaticMethod
{
	public static function foo()
	{

	}

	public function bar()
	{
		$this->foo();
	}
}

class ClassUsingTrait
{
	use TraitWithStaticMethod;
}

function () {
	$classUsingTrait = new ClassUsingTrait();
	$classUsingTrait->foo();
};
