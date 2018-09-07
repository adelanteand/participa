<?php

header("Content-Type: application/javascript");

$op = sololetras($op);
$f  = $baseMod . "/mods/$op/javascript.js";


if (file_exists($f)) {
    echo file_get_contents($f);
}

$subop = sololetras($subop);
$f     = $baseMod . "/mods/$op/$subop.js";

if (file_exists($f)) {
    echo file_get_contents($f);
}