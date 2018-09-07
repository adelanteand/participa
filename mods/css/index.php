<?php
header("Content-Type: text/css");

$op = sololetras($op);
$f  = $baseMod . "/mods/$op/estilo.css";


if (file_exists($f)) {
    echo file_get_contents($f);
}

$subop = sololetras($subop);
$f     = $baseMod . "/mods/$op/$subop.js";

if (file_exists($f)) {
    echo file_get_contents($f);
}