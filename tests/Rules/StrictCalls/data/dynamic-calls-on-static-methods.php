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
		$this->bar();
	}
}

function () {
	$classWithStaticMethod = new ClassWithStaticMethod();
	$classWithStaticMethod->foo();
	$classWithStaticMethod->bar();
};

trait TraitWithStaticMethod
{
	public static function foo()
	{

	}

	public function bar()
	{
		$this->foo();
		$this->bar();
	}
}

class ClassUsingTrait
{
	use TraitWithStaticMethod;
}

function () {
	$classUsingTrait = new ClassUsingTrait();
	$classUsingTrait->foo();
	$classUsingTrait->bar();
};
