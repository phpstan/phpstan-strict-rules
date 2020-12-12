<?php // lint <= 7.4

class CCallToParentConstructor
{

	public function __construct()
	{
		parent::__construct();
	}

}
