<?php

Class Seguridad {
    
}

Class Seguridad_Grupo extends Entidad {

    var $id = 0;
    private $datos = array(
            'tabla'    => "seguridad_grupos",
            'manuales' => array('nombre', 'padre'),
            'fk'       => array(
                'padre' => 'Seguridad_Grupo'
            ),
            'pwd'      => array(),
            'id'       => array('id'),
            'mysql'    => array('created_at', 'updated_at'),
        );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    }

}

Class Seguridad_Grupo_Controlador {

    function getGrupos($UL = false) {
        global $db;

        $cols = array('id', 'nombre', 'padre');
        $res  = $db -> get('seguridad_grupos', null, $cols);
        $out  = Array();
        foreach ($res as $row) {
            $p     = new Seguridad_Grupo($row['id']);
            $out[] = $p;
        }
        
        
        $ordenHijos = $this -> buildTree($out);
        
        if ($UL) {
            return $this -> buildUL($ordenHijos);
        } else {
            return $ordenHijos;
        }
        //return $out;
    }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {            
            if ((!$element -> padre && $parentId == 0) || ($element -> padre -> id == $parentId)) {
                $children = $this -> buildTree($elements, $element -> id);
                if ($children) {
                    $element -> hijos = $children;
                }
                $branch[] = $element;
            }
        }
        
        return $branch;
    }

    function buildUL($arr) {
        $out = "";
        $out .= "<ul>";
        foreach ($arr as $val) {
            if (isset($val -> hijos)) {
                $out .= "<li>" . $val -> nombre;
                $out .= $this -> buildUL($val -> hijos);
                $out .= "</li>";
            } else {
                $out .= "<li>" . $val -> nombre . "</li>";
            }
        }
        $out .= "</ul>";
        return $out;
    }

}
