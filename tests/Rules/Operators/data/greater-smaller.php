<?php

namespace Operators;

use stdClass;

$int = 123;
$string = '123';
$object = new stdClass();
$object2 = new stdClass();

/** @var bool $boolean */
$boolean = foob1();

/** @var bool $boolean2 */
$boolean2 = foob2();

/** @var int|false $intOrFalse */
$intOrFalse = foo();

/** @var int|bool $intOrBoolean */
$intOrBoolean = foo2();

$boolean > $boolean2;
$int > $boolean;
$int > $intOrFalse;

$int <= $intOrBoolean;
$intOrBoolean <= $int;
$intOrBoolean <= $string;

$intOrFalse <= $int;
$intOrFalse <= $string;

$object <= $object2;

for ($i = 0; $i < $intOrFalse; $i++) {
}

$int <=> $intOrFalse;
$intOrFalse <=> $int;

$int < $int;

preg_match_all('~\d+~', 'foo', $matches) > 0;

filesize('foo') > 0;
0 < filesize('foo');

$intOrFalse >= $int;

