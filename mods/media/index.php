<?php

$op = sololetrasynumeros($op);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $x = 1;
} else {
    $x = explode(" ", file_get_contents("/proc/loadavg"));
}

$x = (int) $x[0];

if ($x > 8) {
    exit;
}

$cache_length      = 60 * 5 * $x + rand(0, 60 * 30);
$cache_expire_date = gmdate("D, d M Y H:i:s", time() + $cache_length);

header("Expires: $cache_expire_date");
header("Pragma: cache");
header("Cache-Control: max-age=$cache_length");
header("User-Cache-Control: max-age=$cache_length");

if (isset($_GET['h'])) {
    $h = (int) $_GET['h'];
} else {
    $h = NULL;
}

if (isset($_GET['w'])) {
    $w = (int) $_GET['w'];
} else {
    $w = NULL;
}

$op = sololetrasynumeros($op);

$m = GetMediaFromModulo($op, (int) $subop);

if ($m) {
    $m -> ShowImg($w, $h);
} else {
    $m = new Media();

    $f = $baseMod . "mods/media/default/" . $op . ".png";    
    if (!file_exists($f)) {
        $f = $baseMod . "mods/media/default/default.png";
    }

    $m -> ShowImg($w, $h, $f);
    exit;
}