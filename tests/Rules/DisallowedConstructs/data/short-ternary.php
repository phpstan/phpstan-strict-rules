<?php

/** @var int $cond */
$cond = 123;

$foo = $cond ?: 456;
$bar = $cond ? : 456;
$baz = $cond ? 456 : 789;

/** @var int|false $cond */
$cond = 123;

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var positive-int|false $ */
$cond = 123;

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var object|false $ */
$cond = 123;

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var string|false $ */
$cond = '123';

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var non-empty-string|false $ */
$cond = '123';

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var non-falsy-string|false $ */
$cond = '123';

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var array|false $ */
$cond = [123];

$foo = $cond ?: 456;
$bar = $cond ? : 456;

/** @var non-empty-array|false $ */
$cond = [123];

$foo = $cond ?: 456;
$bar = $cond ? : 456;
