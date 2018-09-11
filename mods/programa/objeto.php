<?php

class Programa_Categoria extends Entidad {

    var $id = 0;
    private $datos = array(
        'tabla' => "programa_categorias",
        'manuales' => array(
            'codigo',
            'nombre',
            'intro',
            'icono',
        ),
        'fk' => array(
            'padre' => 'Programa_Categoria'
        ),
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    }

}

class Programa_Propuesta extends Entidad {

    var $id = 0;
    private $datos = array(
        'tabla' => "programa_propuestas",
        'manuales' => array(
            'cat',
            'texto'
        )
    );

    function __construct($id = 0) {        
        parent::__construct($id, $this->datos);
        //$array_codigo = str_split($this->id, 2);
        //$this->referencia = implode(".",array_map(function($v) { return ltrim($v, '0'); }, $array_codigo));
    }

}

class Programa_Enmienda extends Entidad {
    var $id = 0;
    private $datos = array(
        'tabla' => "programa_enmiendas",
        'manuales' => array(
            'nombre',
            'apellidos',
            'idPropuesta',
            'idCategoria',
            'cp',
            'email',
            'telefono',
            'ip',
            'tipo',
            'motivacion',
            'redaccion',
        ),
        'fk' => array(
            'idCategoria' => 'Programa_Categoria',
            'idPropuesta' => 'Programa_Propuesta'
        ),
        'file' => array(
            'fichero'
        )
    );   
    
    function __construct($id = 0) {        
        parent::__construct($id, $this->datos);
    }    
}

class Programa_Categoria_Controladora {

    public $nivel = 0;

    function __construct() {
        
    }

    function getNivel($padre = NULL) {
        global $db;

        $cols = array('id', 'codigo', 'nombre', 'padre', 'intro', 'icono');
        if ($padre == 0) {
            $db->where('padre', NULL, 'IS');
        } else {
            $db->where('padre', $padre);
        }
        $db->where('activa',1);
        $res = $db->get('programa_categorias', null, $cols);
        $out = Array();
        foreach ($res as $row) {
            $p = new Programa_Categoria($row['id']);
            $out[] = $p;
        }
        return $out;
    }

    function getCategorias($getPropuestas = true) {
        global $db;

        $cols = array('id', 'codigo', 'nombre', 'padre', 'intro', 'icono');
        $db->orderBy("orden", "ASC");
        $db->where('activa',1);
        $res = $db->get('programa_categorias', null, $cols);
        $out = Array();
        foreach ($res as $row) {
            $p = new Programa_Categoria($row['id']);
            $out[] = $p;
        }

        $ordenHijos = $this->anidar($out, 0, $getPropuestas);
        return $ordenHijos;
    }

    function anidar(array $elements, $parentId = 0, $getPropuestas = true) {
        $branch = array();

        foreach ($elements as $element) {
            if ((!$element->padre && $parentId == 0) || ($element->padre->id == $parentId)) {

                if ($getPropuestas) {
                    $prop_tmp = new Programa_Propuesta_Controladora();
                    $element->propuestas = $prop_tmp->getPropuestasCategoria($element->id);
                }

                $children = $this->anidar($elements, $element->id, $getPropuestas);
                if ($children) {
                    $element->hijos = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    function getLista($arr, $nivel = 1, $getPropuestas = true) {
        $out = "";
        $out .= "<ul class=\"nivel-" . $nivel . "\">";
        foreach ($arr as $val) {
            if (isset($val->hijos)) {
                $out .= "<li>" . $val->nombre;
                $out .= $this->getLista($val->hijos, $nivel + 1, $getPropuestas);
                $out .= "</li>";
            } else {
                if ($getPropuestas) {
                    if (isset($val->propuestas)) {
                        $out .= "<li>" . $val->nombre;
                        $out .= "<ul class=\"nivel-" . $nivel . "\">";
                        foreach ($val->propuestas as $p) {
                            $out .= "<li>" . $p->texto . "</li>";
                        }
                        $out .= "</ul>";
                        $out .= "</li>";
                    } else {
                        $out .= "<li>" . $val->nombre . "</li>";
                    }
                } else {
                    $out .= "<li>" . $val->nombre . "</li>";
                }
            }
        }
        $out .= "</ul>";
        return $out;
    }

    function getDIVS($arr, $nivel = 1, $getPropuestas = true) {
        $out = "";

        if ($nivel == 1) {
            $out .= "<div class=\"programa-electoral\">";
        } else {
            $out .= "<div class=\"engloba sub categoria nivel-" . $nivel . "\" data-nivel=" . $nivel . ">";
        }

        foreach ($arr as $val) {
            $out .= "<div class=\"engloba categoria categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=" . $val->id . ">";
            $out .= "<div class=\"titulo categoria categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=" . $val->id . ">";
            $out .= "<span><i class=\"despliegue fas fa-angle-right\"></i> ";
            if ($val->icono){
                $out .= "<i class=\"fas ".$val->icono."\"></i> ";
            }
            $out .= $val->nombre . "</span>";
            $out .= "</div>";

            if ($val->intro) {
                $out .= "<div class=\"descripcion categoria categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=" . $val->id . "><hr>";
                $out .= $val->intro;
                $out .= "</div>";
            }

            if (isset($val->hijos)) {
                $out .= $this->getDIVS($val->hijos, $nivel + 1, $getPropuestas);
            } else {
                if ($getPropuestas) {
                    if (($val->propuestas)) {
                        $out .= "<div class=\"grupo-propuestas categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=\"" . $val->id ."\">";
                        
                        $out .= "<div>";
                        $out .= "<button type='button' data-categoria=\"" . $val->id ."\" class='btn btnadd btn-link btn-sm btnadd' data-accion='add'><i  class='fas fa-plus'></i> Añadir propuesta a ".$val->nombre."</button>";
                        $out .= "</div>";
                        
                        
                        foreach ($val->propuestas as $p) {
                            $out .= "<div class=\"propuesta\" data-idPropuesta=\"" . $p->id . "\" data-idCategoria=\"".$val->id."\">";
                            $out .= "<span data-propuesta=\"" . $p->id . "\" class='badge badge-secondary codigo_propuesta' >Propuesta " . $p->id . "</span> <span class=\"textprop\">" . $p->texto;
                            $out .= "</span><div class='opciones'>";
                            $out .= "<button type='button' class='btn btn-link btn-sm' data-accion='mod'><i class='fas fa-sync-alt'></i> Cambio redacción</button>";
                            $out .= "<button type='button' class='btn btn-link btn-sm' data-accion='sup'><i class='fas fa-trash-alt'></i> Sugerir eliminación</button>";
                            $out .= "</div>";
                            $out .= "</div><hr class=\"divpropuesta\">";
                        }
                        
                        $out .= "<div>";
                        $out .= "<button type='button' data-categoria=\"" . $val->id ."\" class='btn btn-link btn-sm btnadd' data-accion='add'><i data-accion='add' class='fas fa-plus'></i> Añadir propuesta a ".$val->nombre."</button>";
                        $out .= "</div>";                 
                        
                        $out .= "</div>";
                    } else {
                        $out .= "<div>";
                        $out .= "<button type='button' data-categoria=\"" . $val->id ."\" class='btn btnadd btn-link btn-sm btnadd' data-accion='add'><i  class='fas fa-plus'></i> Añadir propuesta a ".$val->nombre."</button>";
                        $out .= "</div>";                        
                    }
                }
            }

            $out .= "</div>";
        }

        $out .= "</div>";

        return $out;
    }

}

class Programa_Propuesta_Controladora {

    function getPropuestasCategoria($id) {

        global $db;
        $cols = array('id', 'cat', 'texto');
        $db->where('cat', $id);
        $db->where('activa',1);
        $res = $db->get('programa_propuestas', null, $cols);

        $out = Array();

        foreach ($res as $row) {
            $p = new Programa_Propuesta($row['id']);
            $out[] = $p;
        }
        return $out;
    }

}
