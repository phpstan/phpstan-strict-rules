<?php

namespace CheckDeprecatedFunctionCall;

foo();
\CheckDeprecatedFunctionCall\foo();

deprecated_foo();
\CheckDeprecatedFunctionCall\deprecated_foo();

non_existent_func();
