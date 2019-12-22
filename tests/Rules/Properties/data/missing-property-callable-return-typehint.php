<?php

namespace MissingPropertyCallableReturnTypehint;

class MyClass
{
	/**
	 * @var callable
	 */
	private $prop1;

	/**
	 * @var callable
	 */
	protected $prop2 = null;

	/**
	 * @var callable
	 */
	public $prop3;
}

class ChildClass extends MyClass
{
	/**
	 * @var callable(): void
	 */
	protected $prop1;

	/**
	 * @var callable(): null
	 */
	protected $prop2;
}
