<?php

namespace FetchingClassConstOfDeprecatedClass;

class Foo
{

	public const FOO = 'FOO';

	/**
	 * @deprecated
	 */
	public const DEPRECATED_FOO = 'FOO';

}

/**
 * @deprecated
 */
class DeprecatedFoo
{

	public const FOO = 'FOO';

	/**
	 * @deprecated
	 */
	public const DEPRECATED_FOO = 'FOO';

}
