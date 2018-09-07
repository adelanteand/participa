<?php

$carpeta = realpath(dirname(__FILE__));
require_once __DIR__ . '/../../html/plugins/autoload.php';
require_once ($carpeta . "/../../clases/funciones.php");
require_once ($carpeta . "/../../config.php");

use GO\Scheduler;

$scheduler = new Scheduler();

//***** LISTA CRON DATABASE ***** //
conectar();
$sql = "SELECT * FROM cron WHERE activo = 1";
$res = mysqli_query($cnx, $sql);

while ($row = mysqli_fetch_array($res)) {
    //var_dump(unserialize($row['php_parameters']));
    if ($row['php_parameters'])
        $scheduler -> php($row['php_base'] . $row['php_script'], $row['php_path'], unserialize($row['php_parameters']), $row['nombre']) -> at($row['cron']) -> onlyOne();
    elseif ($row['nombre'])
        $scheduler -> php($row['php_base'] . $row['php_script'], $row['php_path'], $row['nombre']) -> at($row['cron']) -> onlyOne();
    else
        $scheduler -> php($row['php_base'] . $row['php_script'], $row['php_path']) -> at($row['cron']) -> onlyOne();
}


//var_dump($scheduler);

if (isCli()){
    $scheduler -> run();
}

var_dump($scheduler);

function isCli() {
    return (php_sapi_name() === 'cli');
}
