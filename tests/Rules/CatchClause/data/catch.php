<?php

namespace OverwriteVariablesWithCatchClause;

/**
 * @throws \RuntimeException
 */
function throwsException(): void{
	throw new \RuntimeException();
}

function a(int $e): void{
	try{
		throwsException();
	}catch (\RuntimeException $e){

	}
}

function b(int $e): void{
	try{
		throwsException();
	}catch (\RuntimeException $e_){

	}
}
