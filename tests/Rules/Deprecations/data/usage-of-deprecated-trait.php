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

/**
 * @deprecated
 */
class DeprecatedFoo
{

	use FooTrait;
	use DeprecatedFooTrait;

}

/**
 * @deprecated
 */
class DeprecatedFoo2
{

	use FooTrait,
		DeprecatedFooTrait;

}
