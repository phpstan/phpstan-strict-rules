<?php declare(strict_types = 1);

namespace ArrayFilterStrict;

/** @var list<int> $list */
$list = [1, 2, 3];

/** @var array<string, int> $array */
$array = ["a" => 1, "b" => 2, "c" => 3];

array_filter([1, 2, 3], function (int $value): bool {
	return $value > 1;
});

array_filter([1, 2, 3]);

array_filter([1, 2, 3], function (int $value): bool {
	return $value > 1;
}, ARRAY_FILTER_USE_KEY);

array_filter([1, 2, 3], function (int $value): int {
	return $value;
});

array_filter($list);
array_filter($array);

array_filter($array, null);

array_filter($list, 'intval');

/** @var bool $bool */
$bool = doFoo();
array_filter($list, foo() ? null : function (int $value): bool {
	return $value > 1;
});
