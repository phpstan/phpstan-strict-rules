<?php

namespace StrictCalls;

in_array(1, [1, 2, 3]);
in_array(1, [1, 2, 3], true);
in_array(1, [1, 2, 3], false);
IN_Array(1, [1, 2, 3]);

array_search(1, [1, 2, 3]);
array_search(1, [1, 2, 3], true);
array_search(1, [1, 2, 3], false);
Array_Search(1, [1, 2, 3]);

base64_decode('abcd');
base64_decode('abcd', true);
base64_decode('abcd', false);
Base64_Decode('abcd');

array_keys([1, 2, 3], 1);
array_keys([1, 2, 3], 1, true);
array_keys([1, 2, 3], 1, false);
Array_Keys([1, 2, 3], 1);
array_keys([1, 2, 3]);

$dynamicCall = 'foo';
$dynamicCall();

/** @var bool $bool */
$bool = doFoo();
array_keys([1, 2, 3], 1, $bool);
