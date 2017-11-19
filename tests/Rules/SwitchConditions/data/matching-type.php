<?php

namespace SwitchConditions;

$int = 1;
$string = '1';

switch ($int) {
	case 1:
		break;
	case 'test':
		break;
	case 1 > 2:
		break;
	default:
		return;
}

switch ($string) {
	case 1:
		break;
	case 'test':
		break;
	case 1 > 2:
		break;
	default:
		return;
}
