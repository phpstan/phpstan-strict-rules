<?php

namespace OverwriteVariablesWithForeach;

class Foo
{

	public function doFoo(array $a, array $b, string $str)
	{
		foreach ($a as $val) {

		}

		foreach ($a as $str) {

		}

		foreach ($a as $val) {
			foreach ($b as $var) {

			}
		}
	}

	public function doBar(array $a, string $b, string $d) {
		foreach ($a as [$b, $c, [$d, $e]]) {

		}
	}

	public function doBaz(array $a, string $b, string $d) {
		foreach ($a as list($b, $c, list($d, $e))) {

		}
	}

	public function doLorem(array $a, string $b) {
		foreach ($a as $b => $val) {

		}
		foreach ($a as $c => $val) {

		}
	}

}
