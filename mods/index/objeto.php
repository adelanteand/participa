<?php

class Menu extends Entidad {

    var $modulo = "";
    private $datos = array(
        'tabla' => "modulos",
        'manuales' => array(
            'titulo',
            'menu',
            'publico',
            'enlace',
            'icono'
        ),
        'id' => array('modulo')
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    }

}

class ControladorMenu {

    function getMenu() {
        global $db;
        global $usuario;

        $this->requisites();

        $cols = array('modulo', 'titulo', 'menu', 'publico', 'enlace', 'icono');
        $db->where('menu', 1);
        $db->orderBy('orden', 'ASC');
        $res = $db->get('modulos', null, $cols);

        $out = Array();
        foreach ($res as $row) {
            if ((getPermiso($usuario, $row['modulo']) >= 25) || (in_array($row['modulo'], CONF_PUBLICOS))) {
                $p = new Menu($row['modulo']);
                $out[] = $p;
            }
        }
        return $out;
    }

    function requisites() {
        global $db;

        //Primero comprobamos si existen los requisitos de base de datos
        //suficientes como para hacer las comprobaciones
        $tablas = array('modulos');
        foreach ($tablas as $tabla) {
            if (!$db->tableExists($tabla)) {
                echo "ERROR: No existe la tabla " . DB_PREFIX . $tabla;
                echo "<br>Check db_schema/modulos.sql";
                exit;
            }
        }
    }

}

?>
