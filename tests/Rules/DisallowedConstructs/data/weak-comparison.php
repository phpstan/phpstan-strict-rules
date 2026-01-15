<?php

$bool1 = 123 == 456;
$bool2 = 123 === 456;
$bool3 = 123 != 456;
$bool4 = 123 !== 456;

$bool5 = new DateTime('now') == 1.23;
$bool6 = new DateTime('now') === 1.23;
$bool7 = 1.23 != new DateTime('now');
$bool8 = 1.23 !== new DateTime('now');

$bool9 = new DateTime('now') == null;
$bool10 = new DateTime('now') === null;
$bool11 = null != new DateTime('now');
$bool12 = null !== new DateTime('now');

$bool13 = new DateTime('now') == new DateTime('now');
$bool14 = new DateTime('now') === new DateTime('now');
$bool15 = new DateTime('now') != new DateTime('now');
$bool16 = new DateTime('now') !== new DateTime('now');
