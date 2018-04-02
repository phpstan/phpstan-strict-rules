<?php declare(strict_types = 1);

namespace StrictCalls;

in_array(1, [1, 2, 3]);
in_array(1, [1, 2, 3], true);
in_array(1, [1, 2, 3], false);
in_array(1, [1, 2, 3]);

array_search(1, [1, 2, 3]);
array_search(1, [1, 2, 3], true);
array_search(1, [1, 2, 3], false);
array_search(1, [1, 2, 3]);

base64_decode('abcd');
base64_decode('abcd', true);
base64_decode('abcd', false);
base64_decode('abcd');

array_keys([1, 2, 3], 1);
array_keys([1, 2, 3], 1, true);
array_keys([1, 2, 3], 1, false);
array_keys([1, 2, 3], 1);
array_keys([1, 2, 3]);

$dynamicCall = 'foo';
$dynamicCall();

/** @var bool $bool */
$bool = doFoo();
array_keys([1, 2, 3], 1, $bool);
