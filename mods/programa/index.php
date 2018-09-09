<?php

if (isset($c)) {
    call_user_func(callFuncionParametros($c));
} else {
    call_user_func('programa');
}

function programa() {
    global $html;


    $cats = new Programa_Categoria_Controladora();
    $getPropuestas = true;
    $res = $cats->getCategorias($getPropuestas);
    $lista = $cats->getLista($res, $getPropuestas);
    $divs =  $cats->getDIVS($res, $getPropuestas);

    $html->asignar("ip",getIPv4());
    $html->asignar("programa",$divs);
    $html->plantilla("index.tpl");
    $html->ver();
}

function patio() {
    global $html, $c;

    if (isset($c[1])) {
        $id = $c[1];
    } else {
        $id = 0;
    }
    $cats = new Programa_Categoria_Controladora();
    $cats = $cats->getNivel($id);
    $padre = new Programa_Categoria($id);
    if ($padre->existe) {
        if ($padre->padre->id) {
            $anterior = $padre->padre->id;
        } else {
            $anterior = "ROOT";
        }
    } else {
        $anterior = NULL;
    }

    $propuestas = NULL;

    if (!$cats) {
        $propuestas = new Programa_Propuesta_Controladora();
        $propuestas = $propuestas->getPropuestasCategoria($id);
    }

    $html->asignar("propuestas", $propuestas);
    $html->asignar("anterior", $anterior);
    $html->asignar("cats", $cats);
    $html->plantilla("nivel.tpl");
    $html->ver();
}

function pdf() {
    echo "Disponible próximamente.";
}


function enviar() {
    echo "Formulario de envio";
}