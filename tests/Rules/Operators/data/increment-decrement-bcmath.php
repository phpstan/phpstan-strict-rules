<?php

namespace Operators;

use BcMath\Number;

function testPostDecrement(Number $x): Number {
        return $x--;
}

function testPostIncrement(Number $x): Number {
        return $x++;
}

function testPreDecrement(Number $x): Number {
        return --$x;
}

function testPreIncrement(Number $x): Number {
        return ++$x;
}
