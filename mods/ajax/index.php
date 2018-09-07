<?php

//header('Content-Type: application/json; charset=utf-8', true, 200);

$mod = sololetras($op);
$op  = $subop;

if (isset($c[3])) {
    $subop = $c[3];
} else {
    $subop = null;
}

importclass($mod);

$f = $baseMod . "mods/$mod/ajax.php";

$html -> template_dir = $baseMod . '/mods/' . $mod . '/tpl/';
$html -> compile_dir  = $home . '/smarty/templates_c/' . $mod . '/';
$html -> config_dir   = $home . '/smarty/configs/' . $mod . '/';
$html -> cache_dir    = $home . '/smarty/cache/' . $mod . '/';

if (file_exists($f)) {
    require ($f);
}