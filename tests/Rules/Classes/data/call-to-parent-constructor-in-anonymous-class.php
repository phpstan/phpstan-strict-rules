<?php

namespace CallToParentConstructorInAnonymousClass;

class Foo
{

	public function __construct()
	{
	}

}

new class extends Foo {

	public function __construct()
	{
	}

};
