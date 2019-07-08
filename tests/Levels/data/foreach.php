<?php

function (): void {
	foreach ([1, 2, 3] as $val) {
		if (rand(0, 1) === 0) {
			break;
		}
		$test = 1;
	}

	echo $test;
};
