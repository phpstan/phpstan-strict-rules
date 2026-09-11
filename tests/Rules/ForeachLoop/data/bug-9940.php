<?php declare(strict_types = 1);

namespace Bug9940;

class HelloWorld
{
	public function checkQuery(): void
	{
		$queryStrings = [];
		foreach (doSomething() as $queryString) {
			$queryStrings[] = $queryString;
		}

		if ($queryStrings === []) {
			return;
		}

		foreach ($queryStrings as $queryString) {
		}
	}
}

/** @return array<string> */
function doSomething():array {
	return [];
}
