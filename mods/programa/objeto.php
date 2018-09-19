<?php

class Programa_Categoria extends Entidad {

    var $id = 0;
    private $datos = array(
        'tabla' => "programa_categorias",
        'manuales' => array(
            'codigo',
            'nombre',
            'icono',
        ),
        'fk' => array(
            'padre' => 'Programa_Categoria'
        ),
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    }
    
    function getIntro(){
        $introducciones = new Programa_Propuesta_Controladora();
        $this->intro = $introducciones->getPropuestasCategoria($this->id, 'intro');                
    }
    
    function getEnmiendas() {        
        $enmiendas = new Programa_Enmienda_Controladora();
        $resEnmiendas = $enmiendas->getEnmiendasFrom($this->id,'idCategoria');
        if ($resEnmiendas){
            $this->enmiendas = $resEnmiendas;
        } else {
            $this->enmiendas = null;
        }
        
    }    
    

}

class Programa_Propuesta extends Entidad {

    var $id = 0;
    private $datos = array(
        'tabla' => "programa_propuestas",
        'manuales' => array(
            'cat',
            'texto',
            'tipo'
        ),
        'fk' => array(
            'cat' => 'Programa_Categoria'
        )
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);

        //$array_codigo = str_split($this->id, 2);
        //$this->referencia = implode(".",array_map(function($v) { return ltrim($v, '0'); }, $array_codigo));
    }
    
    function getEnmiendas() {
        
        $enmiendas = new Programa_Enmienda_Controladora();
        $resEnmiendas = $enmiendas->getEnmiendasFrom($this->id,'idPropuesta');
        if ($resEnmiendas){
            $this->enmiendas = $resEnmiendas;
        } else {
            $this->enmiendas = null;
        }
        
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
            'publica',
            'random'
        ),
        'fk' => array(
            'idCategoria' => 'Programa_Categoria',
            'idPropuesta' => 'Programa_Propuesta',
            'cp' => 'CP'
        ),
        'file' => array(
            'fichero'
        )
    );

    function __construct($id = 0) {
        importclass("geografico");
        if (is_array($id)) {
            $id['publica'] = "0";
            $id['random'] = generateRandomString(256);
        }
        
        parent::__construct($id, $this->datos);
        
    }
    
    function editar($id) {
        return parent::edit($id, $this->datos);
    }    
    
    function setVisible($valor = 1){
        $this->publica = $valor;
    }
}

class Programa_Enmienda_Controladora {
    

    function getEnmiendasFrom($id,$from = 'idPropuesta') {

        global $db;
        $db->where($from, $id);
        if ($from=='idCategoria'){
            $db->where('idPropuesta', null, 'IS');
        }        
        $db->where('publica', 1);
        $res = $db->get('programa_enmiendas', null);

        $out = Array();

        foreach ($res as $row) {
            $p = new Programa_Enmienda($row['id']);
            $out[] = $p;
        }
        return $out;
    }
    
    function getEnmiendasProvincia($idProvincia){
        global $db;
        $db->where('cp', $idProvincia."%", 'LIKE');
        $res = $db->get('programa_enmiendas', null);

        $out = Array();

        foreach ($res as $row) {
            $p = new Programa_Enmienda($row['id']);
            $out[] = $p;
        }
        return $out;        
    }
}



class Programa_Categoria_Controladora {

    public $nivel = 0;

    function __construct() {

        
    }

    function getNivel($padre = NULL) {
        global $db;

        $cols = array('id', 'codigo', 'nombre', 'padre', 'icono');
        if ($padre == 0) {
            $db->where('padre', NULL, 'IS');
        } else {
            $db->where('padre', $padre);
        }
        $db->where('activa', 1);
        $res = $db->get('programa_categorias', null, $cols);
        $out = Array();
        foreach ($res as $row) {
            $p = new Programa_Categoria($row['id']);
            $p->getEnmiendas();
            $out[] = $p;
        }
        return $out;
    }

    function getCategorias($getPropuestas = true) {
        global $db;

        $cols = array('id', 'codigo', 'nombre', 'padre', 'icono');
        $db->orderBy("orden", "ASC");
        $db->where('activa', 1);
        $res = $db->get('programa_categorias', null, $cols);
        $out = Array();
        foreach ($res as $row) {
            $p = new Programa_Categoria($row['id']);
            $p->getIntro();
            $p->getEnmiendas();
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
                    $element->propuestas = $prop_tmp->getPropuestasCategoria($element->id, 'propuesta');
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
            if ($val->icono) {
                $out .= "<i class=\"fas " . $val->icono . "\"></i> ";
            }
            $out .= $val->nombre . "</span>";
            $out .= "</div>";

            if ($val->intro) {
                $out .= "<div class=\"descripcion categoria categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=" . $val->id . ">";
                foreach ($val->intro as $intro) {
                    $out .= "<p class=\"parrafo\"  data-idPropuesta=\"" . $intro->id . "\" data-idCategoria=\"" . $val->id . "\">";
                    $out .=  "<span data-propuesta=\"" . $intro->id . "\" class='badge badge-secondary codigo_parrafo' >" . $intro->id . "</span> ";
                    $out .= "<span class='textprop'>".$intro->texto."</span>";
                    $out .= "<span class='opciones'>";
                    $out .= "<button type='button' class='btn btn-link btn-sm' data-accion='mod' data-tipo='parrafo'><i class='fas fa-sync-alt'></i> Cambio redacción</button>";
                    $out .= "<button type='button' class='btn btn-link btn-sm' data-accion='sup' data-tipo='parrafo'><i class='fas fa-trash-alt'></i> Sugerir eliminación</button>";
                    $out .= "</span>";                    
                    $out .= "</p>";
                }
                $out .= "</div>";
            }

            if (isset($val->hijos)) {
                $out .= $this->getDIVS($val->hijos, $nivel + 1, $getPropuestas);
            } else {
                if ($getPropuestas) {
                    if (($val->propuestas)) {
                        $out .= "<div class=\"grupo-propuestas categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=\"" . $val->id . "\">";

                        $out .= "<div>";
                        $out .= "<button type='button' data-categoria=\"" . $val->id . "\" class='btn btnadd btn-link btn-sm btnadd' data-accion='add'><i  class='fas fa-plus'></i> Añadir propuesta a " . $val->nombre . "</button>";
                        $out .= "</div>";


                        foreach ($val->propuestas as $p) {
                            $out .= "<div class=\"propuesta\" data-idPropuesta=\"" . $p->id . "\" data-idCategoria=\"" . $val->id . "\">";
                            $out .= "<span data-propuesta=\"" . $p->id . "\" class='badge badge-secondary codigo_propuesta' >Propuesta " . $p->id . "</span> <span class=\"textprop\">" . $p->texto;
                            $out .= "</span><div class='opciones'>";
                            $out .= "<button type='button' class='btn btn-link btn-sm' data-tipo='propuesta' data-accion='mod'><i class='fas fa-sync-alt'></i> Cambio redacción</button>";
                            $out .= "<button type='button' class='btn btn-link btn-sm' data-tipo='propuesta' data-accion='sup'><i class='fas fa-trash-alt'></i> Sugerir eliminación</button>";
                            $out .= "</div>";
                            $out .= "</div><hr class=\"divpropuesta\">";
                        }

                        $out .= "<div>";
                        $out .= "<button type='button' data-categoria=\"" . $val->id . "\" class='btn btn-link btn-sm btnadd' data-tipo='propuesta' data-accion='add'><i data-accion='add' class='fas fa-plus'></i> Añadir propuesta a " . $val->nombre . "</button>";
                        $out .= "</div>";

                        $out .= "</div>";
                    } else {
                        $out .= "<div class=\"grupo-propuestas categoria-" . $val->id . " nivel-" . $nivel . "\" data-nivel=" . $nivel . " data-categoria=\"" . $val->id . "\">";
                        $out .= "<div>";
                        $out .= "<button type='button' data-categoria=\"" . $val->id . "\" class='btn btnadd btn-link btn-sm btnadd' data-tipo='propuesta' data-accion='add'><i  class='fas fa-plus'></i> Añadir propuesta a " . $val->nombre . "</button>";
                        $out .= "</div>";
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

    function getPropuestasCategoria($id, $tipo = 'propuesta') {

        global $db;
        $cols = array('id', 'cat', 'texto', 'tipo', 'CONVERT(substring(id,2),UNSIGNED INTEGER) id_numero');
        $db->where('cat', $id);
        $db->where('tipo', $tipo);
        $db->where('activa', 1);
        $db->orderBy('id_numero','asc');
        $res = $db->get('programa_propuestas', null, $cols);

        $out = Array();

        foreach ($res as $row) {
            $p = new Programa_Propuesta($row['id']);
            $p->getEnmiendas();
            $out[] = $p;
        }
        return $out;
    }

}


class Patio_Evento Extends Entidad {
    
    var $id = 0;
    
    private $datos = array(
        'tabla' => "patio_evento",
        'manuales' => array(
            'ciudad',
            'direccion',
            'cp',            
            'ubicacion',
            'fecha_inicio'
        ),
        'fk' => array(
            'cp' => 'CP'
        )
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);        
    }
    
}

class Patio_Inscripcion Extends Entidad {
    
    var $id = 0;
    
    private $datos = array(
        'tabla' => "patio_inscripcion",
        'manuales' => array(
            'patio',
            'nombre',
            'apellidos',            
            'email',
            'telefono',
            'cp',
            'ip',
            'ejes',
            'ludoteca',
            'andaluz',
            'observaciones'
        ),
        'fk' => array(
            'patio' => 'Patio_Evento',
            'cp' => 'CP'
        )
    );

    function __construct($id = 0) {           
        parent::__construct($id, $this->datos);        
    }
    
}


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

