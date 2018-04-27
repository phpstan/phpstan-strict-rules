<?php declare(strict_types = 1);

namespace ImplicitArrayCreation;

class Foo
{

	public function doFoo($a)
	{
		$a['foo'] = 'test';
		$b[] = 'test';

		if (doFoo()) {
			$c = [];
		}

		$c['foo'] = 'test';
		$d[][] = 'blabla';
	}

}
