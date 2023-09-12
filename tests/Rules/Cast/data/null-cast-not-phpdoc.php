<?php

namespace NullCastNotPhpDoc;

class Foo
{

	/**
	 * @param int|null $phpDocIntegerOrNull
	 */
	public function doFoo(
		int $realInteger,
		$phpDocIntegerOrNull
	): void
	{
		$foo = (int) $realInteger;
		$bar = (int) $phpDocIntegerOrNull;
	}

}
