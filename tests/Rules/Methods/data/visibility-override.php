<?php

namespace MethodVisibilityOverride;

class BaseClass
{

	protected function __construct()
	{

	}

	public function foo1()
	{

	}

	protected function foo2()
	{

	}

	protected function foo3()
	{

	}

	private function foo4()
	{

	}

	private function foo5()
	{

	}

	private function foo6()
	{

	}

}

class SubClass extends BaseClass
{

	public function __construct()
	{

	}

	public function foo1()
	{

	}

	protected function foo2()
	{

	}

	public function foo3()
	{

	}

	public function foo4()
	{

	}

	protected function foo5()
	{

	}

	protected function foo6()
	{

	}

}

class OtherSubClass extends BaseClass
{

}

class OtherSubSubClass extends OtherSubClass
{

	public function foo3()
	{

	}

}
