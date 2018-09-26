<?php

$carpeta = realpath(dirname(__FILE__));
require_once ($carpeta . "/../../config.php");

//require '../vendor/autoload.php'; //COMPOSER APP
require_once BASEAPP . 'vendor/autoload.php'; //COMPOSER BASE
require_once BASEAPP . 'clases/funciones.php'; //FUNCIONES BASE

use GO\Scheduler;



$scheduler = new Scheduler();

//***** LISTA CRON DATABASE ***** //
$db = new MysqliDb(Array(
    'host'     => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PWD,
    'db'       => DB_DB,
    'port'     => DB_PORT,
    'prefix'   => DB_PREFIX,
    'charset'  => 'utf8'));

$db->where("activo",1);
$res = $db->get('cron', null);



foreach ($res as $row) {
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
