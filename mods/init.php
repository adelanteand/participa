<?php

$menusadmin=Array();
$cola=false;
/*
var_dump((getPermiso($usuario,$mod)));
var_dump ((!in_array($mod,CONF_PUBLICOS)));
var_dump(CONF_PUBLICOS);
*/

if ((!in_array($mod,CONF_PUBLICOS))) {
    //echo "NO TIENES PERMISOS";    
    //$html -> display($home."tpl/header.tpl");
    $html -> display($home."tpl/error.tpl");
    exit; 
}

$html->assign("menusadmin",$menusadmin);