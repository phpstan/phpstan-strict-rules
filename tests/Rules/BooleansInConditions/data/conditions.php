<?php

namespace BooleanCondiitons;

$string = 'str';
$bool = true;
if (doFoo()) {
	$bool = false;
}

/** @var mixed $explicitMixed */
$explicitMixed = doFoo();

$bool && $bool;
$string && $bool;
$bool && $string;
$string && $string;
$bool && doFoo();
$bool && $explicitMixed;

!$bool;
!$string;

$bool || $bool;
$string || $bool;
$bool || $string;
$string || $string;
$bool || doFoo();
$bool || $explicitMixed;

if ($bool) {

} elseif ($bool) {

} elseif ($string) {

}

if ($string) {

}

$bool ? 1 : 2;
$string ? 1 : 2;
$string ?: null;

$bool and $explicitMixed;
$explicitMixed and $bool;
$bool or $explicitMixed;
$explicitMixed or $bool;
