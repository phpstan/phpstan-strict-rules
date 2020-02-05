<?php

namespace OverwriteVariablesWithForLoopInit;

class Foo{

	public function simple(int $i): void
	{
		for($i = 0; $i < 10; ++$i){
		
		}
	}

	public function multi(int $i, int $j): void
	{
		for($i = 0, $j = 0; $i < 10; ++$i){
			
		}

		for($i = 0, $k = 0; $i < 10; ++$i){

		}
	}

	public function list(int $i, int $j, array $b): void
	{
		for(list($i, $j) = $b; $i < 10; ++$i){

		}

		for(list($i, list($j, $k)) = $b; $i < 10; ++$i){

		}
	}

	public function array(int $i, array $b): void
	{
		for([$i, $j] = $b; $i < 10; ++$i){

		}

		for([$i, [$j, $k]] = $b; $i < 10; ++$i){

		}
	}
}