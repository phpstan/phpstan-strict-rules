<?php declare(strict_types = 1);

namespace PHPStan\Levels\ArithmeticOperators;

class Foo
{

	/**
	 * @param int $int
	 * @param string $string
	 * @param int|string $intOrString
	 */
	public function doFoo(
		int $int,
		string $string,
		$intOrString
	): void
	{
		$literalNumericString = '123';
		$intOrLiteralNumericString = $int;
		if (rand(0, 1) === 0) {
			$intOrLiteralNumericString = '123';
		}

		$int + $int;
		$string + $int;
		$literalNumericString + $int;
		$intOrString + $int;
		$intOrLiteralNumericString + $int;

		$stringOrObject = $string;
		if (rand(0, 1) === 0) {
			$stringOrObject = new \stdClass();
		}

		$stringOrObject + $int;

		$unionOfLiterals = '123';
		if (rand(0, 1) === 0) {
			$unionOfLiterals = '456';
		}

		$unionOfLiterals + $int;
	}

}
