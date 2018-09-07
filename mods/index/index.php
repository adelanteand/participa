<?php


if ($usuario -> id == 0) {    
    //$html -> display("portada_anonima.tpl");
} else {
    echo "sesion iniciada";
}

$html->assign("plantilla","bienvenida.tpl");
$html->display($baseMod.'tpl/default.tpl');