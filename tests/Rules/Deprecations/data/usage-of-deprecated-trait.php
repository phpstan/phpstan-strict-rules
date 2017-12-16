<?php

namespace UsageOfDeprecatedTrait;

class Foo
{

	use FooTrait;
	use DeprecatedFooTrait;

}

class Foo2
{

	use FooTrait,
		DeprecatedFooTrait;

}
