<?php
importclass("modulos",BASEAPP);
call_user_func(callFuncionParametros($c));

function seguridad() {
    global $html;
    $html->plantilla("index.tpl");
    $html->ver();
}

function seguridad_modulos() {
    global $html, $baseMod, $home;

    //LEEMOS LOS DE LA APLICACION BASE


    $base_name = array_filter(explode("/", $baseMod));
    $base_name = end($base_name);
    $base_dir = array();
    foreach (glob($baseMod . "/mods/*", GLOB_ONLYDIR) as $dir) {
        $base_dir[] = basename($dir);
    }
    sort($base_dir);

    $home_name = array_filter(explode("/", $home));
    $home_name = end($home_name);
    $home_dir = array();
    foreach (glob($home . "/mods/*", GLOB_ONLYDIR) as $dir) {
        $home_dir[] = basename($dir);
    }
    sort($home_dir);

    $modulos_dir = array();

    foreach ($home_dir as $dir) {
        if (!in_array($dir, array_column($modulos_dir, 'mod'))) {
            $modulos_dir[] = array('mod' => $dir, 'app' => $home_name);
        }
    }
    foreach ($base_dir as $dir) {
        if (!in_array($dir, array_column($modulos_dir, 'mod'))) {
            $modulos_dir[] = array('mod' => $dir, 'app' => $base_name);
        }
    }

    var_dump($modulos_dir);
    foreach ($modulos_dir as $modulo){
        $m = new Modulo($modulo['mod']);
        
    }
//    $html->asignar("modulos", $modulos_dir);
//    $html->plantilla("modulos.tpl");
//    $html->ver();
}

function seguridad_grupos() {
    global $html;
    $listado = new Seguridad_Grupo_Controlador();
    //$listadoGrupos = $listado -> getGrupos(false);    
    $listadoUL = $listado->getGrupos(true);
    $html->asignar("ListadoGrupos", $listadoUL);
    $html->plantilla("grupo_index.tpl");
    $html->ver();
}

function seguridad_grupos_add() {
    global $html;
    $html->plantilla("grupo_add.tpl");
    $html->ver();
}

function seguridad_grupos_add_go() {
    global $baseurl;
    $grupo = new Seguridad_Grupo(filter_input_array(INPUT_POST));
    header("Location: " . $baseurl . "/seguridad/grupos/");
}

function seguridad_usuarios() {
    global $html;
    $listado = new Usuarios_Controlador();
    $listado = $listado->getUsuarios();
    $html->botones("usuarios_index.botones.tpl");
    $html->asignar("ListadoUsuarios", $listado);
    $html->plantilla("usuarios_index.tpl");
    $html->ver();
}

function seguridad_usuarios_add() {
    global $html;
    $html->asignar("randomPass", substr(md5(microtime()), 1, 8));
    $html->asignar("accion", 'add/go');
    $html->botones("usuarios_form.botones.tpl");
    $html->plantilla("usuarios_form.tpl");
    $html->ver();
}

function seguridad_usuarios_add_go() {
    //ALMACENAR DATOS RECIBIDOS    
    global $db;
    $usuario = new Usuario($_POST);
    call_user_func('seguridad_usuarios');
}

function seguridad_usuarios_editar() {
    global $html, $c;
    if (!$c[3]) {
        exit("Indique ID");
    }
    $usuario = new Usuario($c[3]);
    $html->asignar("val", $usuario);
    $html->asignar("accion", 'editar/go');
    $html->botones("usuarios_form.botones.tpl");
    $html->plantilla("usuarios_form.tpl");
    $html->ver();
}

function seguridad_usuarios_editar_go() {
    //ALMACENAR DATOS RECIBIDOS    
    global $db;
    $usuario = new Usuario($_POST['idusuario']);
    $usuario->editar($_POST);
    call_user_func('seguridad_usuarios');
}

function seguridad_usuarios_eliminar() {
    global $html, $c;
    if (!$c[3]) {
        exit("Indique ID");
    }
    $usuario = new Usuario($c[3]);
    $usuario->eliminar();
    call_user_func('seguridad_usuarios');
}
