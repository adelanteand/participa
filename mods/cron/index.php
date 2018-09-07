<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$carpeta = realpath(dirname(__FILE__));
require_once __DIR__ . '/../../html/plugins/autoload.php';
require_once ($carpeta . "/../../config.php");


if ($op == 'scheduler') {
    require_once 'scheduler.php';
}

if ($op == 'karma') {

    if ($subop == $password_automat) {
        $usuarios = new ControladorUsuarios;
        $usuarios -> setKarma();
        echo "Ejecutado";
    } else {
        echo "Error";
    }
}

if ($op == 'cleanYoutube') {

    importclass("videos");

    if ($subop == $password_automat) {

        $cp     = new ControladoraPlaylist();
        $listas = $cp -> getPlaylists();
        //var_dump($listas);
        foreach ($listas as $p) {

            $pl = new Playlist($p -> id);
            $pl -> getContenido(); //cargamos su contenido completo

            foreach ($pl -> contenido as $elemento) {
                $nombreElementoPlaylist = $elemento['modelData']['snippet']['title'];
                if ($nombreElementoPlaylist == 'Deleted video' || $nombreElementoPlaylist == 'ELIMINAR') {
                    var_dump("Deleted " . $elemento['id'] . "from playlist " . $pl -> playlist);
                    $pl -> removeFromPlaylist($elemento['id']);
                }
            }
        }
        echo "Ejecutado";
    } else {

        echo "Error";
    }
}


if ($op="test"){
    // PARA HACER PRUEBAS
    //require_once('tareas/tracking_votes.php');
}

