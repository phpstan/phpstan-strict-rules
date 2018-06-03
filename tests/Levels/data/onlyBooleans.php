<?php declare(strict_types = 1);

namespace PHPStan\Levels\OnlyBooleans;

class Foo
{

	/**
	 * @param bool $bool
	 * @param mixed $explicitMixed
	 * @param int|false $intOrFalse
	 * @param float|string $floatOrString
	 */
	public function doFoo(
		bool $bool,
		int $int,
		$mixed,
		$explicitMixed,
		$intOrFalse,
		$floatOrString
	): void
	{
		if ($bool) {

		}
		if ($int) {

		}
		if ($mixed) {

		}
		if ($explicitMixed) {

		}
		if ($intOrFalse) {

		}
		if ($floatOrString) {

		}
	}

}
