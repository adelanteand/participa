<?php

/*
 * INICIO DE SESIONES
 */
session_start();
session_regenerate_id();


/*
 * IMPORTAR CONFIGURACION
 * EN FUNCION SI ES BASE
 * O APLICACION CONECTADA
 */
if (!file_exists('../config.php')) {
    echo "No existe config.php";
    exit;
} else {
    if (!defined('BASEAPP')) {
        require ("../config.php");
    } elseif (BASEAPP == "") {
        require ("../config.php");
    } else {
        require (BASEAPP . "config.php");
    }
}

if (!defined('BASEAPP')) {
    echo "NO APP CONECTED";
    exit;
} else {
    //echo "Conectado a aplicacion base";
}

/*
 * CARGAR DINAMICAMENTE LIBERIAS
 * COMPOSER Y CLASES BÁSICAS
 */
require '../vendor/autoload.php'; //COMPOSER APP
require BASEAPP . 'vendor/autoload.php'; //COMPOSER BASE
require BASEAPP . 'clases/funciones.php'; //FUNCIONES BASE


/*
 * CONEXIÓN A LA BASE DE DATOS 
 * DE LA APLICACION EN USO
 */
$db = new MysqliDb(Array(
    'host' => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PWD,
    'db' => DB_DB,
    'port' => DB_PORT,
    'prefix' => DB_PREFIX,
    'charset' => 'utf8'));


/*
 * ESTABLECER ZONA HORARIA
 */
date_default_timezone_set(CONF_TIMEZONE);
setlocale(LC_TIME, CONF_LOCALE);
$home = CONF_HOME;


/*
 * IMPORTAR CLASES ELEMENTALES
 */
importclass("entidad", BASEAPP);
importclass("smarty", BASEAPP);
importclass("usuario", BASEAPP);
importclass("index", BASEAPP);


/*
 * SESION DE USUARIO Y CARGA EN 
 * VARIABLE $usuario 
 * (PRESENTE EN TODA LA APLICACION)
 */
if (isset($_SESSION['usuario'])) {
    $usuario = new Usuario($_SESSION['usuario']);
} else {
    $usuario = new Usuario(0);
}

/*
 * SESION CSRF PARA PROTECCIÓN DEL SITIO
 */
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];


if (isset($_REQUEST['carpeta']) && strpos($_REQUEST['carpeta'], 'telegram') === false) {
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
        //detectamos que ha habido un envio POST (formulario)
        if (!isset($_POST['token'])) {
            exit("ERROR: Envio de formulario sin protección CSRF.<br>"
                    . "<pre>"
                    . "&#x7B;&#x69;&#x6E;&#x63;&#x6C;&#x75;&#x64;&#x65;&#x20;"
                    . "&#x66;&#x69;&#x6C;&#x65;&#x3D;&#x22;&#x24;&#x62;&#x61;&#x73;"
                    . "&#x65;&#x41;&#x50;&#x50;&#x2F;&#x74;&#x70;&#x6C;&#x2F;&#x63;"
                    . "&#x73;&#x72;&#x66;&#x2E;&#x74;&#x70;&#x6C;&#x22;&#x7D;"
                    . "</pre>");
        } else {
            if (!($_POST['token'] === $_SESSION['token'])) {
                exit("ERROR: Validación CSRF errónea");
            }
        }
    }
}




/*
 * CARGA DE SMARTY
 * (CLASES/SMARTY.PHP)
 */
$html = new Plantilla();


/*
 * PERMISOS DE ADMINISTRACIÓN
 */
$permisos = GetPermiso($usuario, "admin");
$isadmin = (100 == $permisos);


/*
 * LECTURA DE VARIABLES
 * (VER .HTACCESS)
 */
var_dump($_REQUEST);exit;
unset($op);
unset($subop);
unset($mod);

$mod = null;
$op = null;
$subop = null;

if (isset($_GET["carpeta"])) {
    $c = explode("/", $_GET["carpeta"]);

    if (array_key_exists(0, $c)) {
        $mod = $c[0];
    }

    if (array_key_exists(1, $c)) {
        $op = $c[1];
    }

    if (array_key_exists(2, $c)) {
        $subop = $c[2];
    }
}

if (isset($_POST["mod"])) {
    $mod = $_POST["mod"];
}

if (isset($_GET["mod"])) {
    $mod = $_GET["mod"];
}

if (isset($_POST["op"])) {
    $op = $_POST["op"];
}

if (isset($_GET["op"])) {
    $op = $_GET["op"];
}

if (isset($_POST["subop"])) {
    $subop = $_POST["subop"];
}

if (isset($_GET["subop"])) {
    $subop = $_GET["subop"];
}

$mod = sololetras($mod);

$html->assign("isadmin", $isadmin);

if (isset($op)) {
    $html->assign("op", $op);
}

if (isset($subop)) {
    $html->assign("subop", $subop);
}

if ((!file_exists($home . "/mods/$mod")) || (strlen($mod) < 2)) {
    if ((!file_exists(BASEAPP . "/mods/$mod")) || (strlen($mod) < 2)) {
        $mod = CONF_INDEX_MODULO;
    }
}

$baseMod = baseModulo($mod);
$html->assign("mod", ucwords($mod));
$html->assign("baseMod", $baseMod);
$html->assign("DEBUG", CONFIG_DEBUG);


directorio($baseMod . '/mods/' . $mod . '/tpl/');
directorio($home . '/smarty/templates_c/' . $mod . '/');
directorio($home . '/smarty/configs/' . $mod . '/');
directorio($home . '/smarty/cache/' . $mod . '/');

$html->template_dir = $baseMod . '/mods/' . $mod . '/tpl/';
$html->compile_dir = $home . '/smarty/templates_c/' . $mod . '/';
$html->config_dir = $home . '/smarty/configs/' . $mod . '/';
$html->cache_dir = $home . '/smarty/cache/' . $mod . '/';

$js = Array();
$jspie = Array();
$css = Array();

// eskeleton";
#if( ($mod!="propongo") &&  ($mod!="usuarios"))
if (false) {
    $css[] = "/css/skeleton/base.css";
    $css[] = "/css/skeleton/layout.css";
    $css[] = "/css/skeleton/skeleton.css";
    $css[] = "/css/skeleton/tables.css";
    $css[] = "/css/style.css";
} else {
    
}


$js[] = "/js/index.js";
if (file_exists($baseMod . "/mods/$mod/javascript.js")) {
    $js[] = "/js/$mod/?" . rand(0, 2222222);
}

if (file_exists($baseMod . "/mods/$mod/estilo.css")) {
    $css[] = "/css/$mod/?" . rand(0, 2222222);
}


//index/objeto.php
$cmenu = new ControladorMenu();
$menu = $cmenu->getMenu();
$html->assign("menu", $menu);

$html->assign("js", $js);
$html->assign("jspie", $jspie);
$html->assign("css", $css);

importclass($mod, $baseMod);

if (file_exists(BASEAPP . "mods/init.php")) {
    require (BASEAPP . "mods/init.php");
} else {
    if ($home . "mods/init.php") {
        require ($home . "mods/init.php");
    }
}

require ($baseMod . "mods/$mod/index.php");
