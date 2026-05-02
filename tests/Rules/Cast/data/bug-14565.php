<?php // lint >= 8.5

namespace Bug14565;

class Foo
{

	#[\NoDiscard]
	public function bar(): int
	{
		return 1;
	}

}

function (Foo $foo): void {
	(void) $foo->bar();
};
