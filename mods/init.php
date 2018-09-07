<?php

$menusadmin=Array();
$cola=false;


if ((getPermiso($usuario,$mod) < 25) && (!in_array($mod,CONF_PUBLICOS))) {
    //echo "NO TIENES PERMISOS";    
    //$html -> display($home."tpl/header.tpl");
    $html -> display($home."tpl/error.tpl");
    exit; 
}

$html->assign("menusadmin",$menusadmin);