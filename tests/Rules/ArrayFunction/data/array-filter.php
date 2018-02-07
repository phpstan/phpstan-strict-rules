<?php

namespace ArrayFunction;

array_filter([1, 2, 3]);
array_filter([1, 2, 3], function (int $a): string { return 'a'; });
array_filter([1, 2, 3], function (int $a): bool { return true; });
array_filter([1, 2, 3], function (int $a): ?bool { return null; });
Array_Filter([1, 2, 3], function (int $a): bool { return true; });
