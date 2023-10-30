<?php // lint >= 8.1

namespace Bug231;

enum MyEnum: string
{
	case Foo = 'foo';
	case Bar = 'bar';
	case Baz = 'baz';

	public function isB(): bool
	{
		return in_array($this, strict: true, haystack: [
			self::Bar,
			self::Baz,
		]);
	}
}
