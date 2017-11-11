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

$dynamicCall = 'foo';
$dynamicCall();
