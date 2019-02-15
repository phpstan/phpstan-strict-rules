<?php

namespace MissingPropertyTypehint;

class MyClass
{
	private $prop1;

	protected $prop2 = null;

	/**
	 * @var
	 */
	public $prop3;

	/**
	 * @var array
	 */
	public $prop4;

	/**
	 * @var iterable
	 */
	public $prop5;

	/**
	 * @var \ArrayObject
	 */
	public $prop6;
}

class ChildClass extends MyClass
{
	/**
	 * @var int
	 */
	protected $prop1;

	/**
	 * @var null
	 */
	protected $prop2;

	/**
	 * @var array<string>
	 */
	public $prop4;

	/**
	 * @var iterable<string>
	 */
	public $prop5;

	/**
	 * @var \ArrayObject<string>
	 */
	public $prop6;
}
