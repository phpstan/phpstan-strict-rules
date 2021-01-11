<?php

namespace Bug104;

class Foo
{

	public function foo(?string $bar): void
	{
		if ($bar !== null && strpos($bar, 'bar') === 0) {
			echo 'strpos works';
		}
		if ($bar !== null && $bar) {
			echo 'string as boolean does not';
		}
	}

	public function bar(?bool $bar): void
	{
		if ($bar !== null && $bar) {
			echo 'foo';
		}
	}

}
