<?php

class ColegioElectoral extends Entidad {

    var $id = 0;
    private $datos = array(
        'tabla' => "colegios_electorales",
        'manuales' => array(
            'nombre',
            'municipio',
            'direccion',
            'CP',
            'mesas',
            'votantes',
            'latitud',
            'longitud',
        )
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    }

}

class Apoderado extends Entidad {
    
    var $id = 0;
    private $datos = array(
        'tabla' => "apoderados",
        'manuales' => array(
            'nombre',
            'apellido_1',
            'apellido_2',
            'genero',
            'email',
            'telefono',
            'dni',
            'fecha_nacimiento',
            'movilidad',
            'profesion',
            'provincia',
            'municipio',
            'direccion',
            'num',
            'piso',
            'cp',
            'colegio',
            'voluntario',
            'observaciones',
            'disponibilidad',
            'token',
        )
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    } 
    
    function getColegio(){
        $this->colegio = new ColegioElectoral($this->colegio);        
    }
    
}

class Apoderados_Controladora {
    
    var $provincia = null;
    
    function getApoderados() {
        global $db;
        
        if ($this->provincia) {
            $db->where('provincia', $this->provincia);
        }        
        
        $db->where('colegio', NULL, 'IS NOT');
        
        $res = $db->get('apoderados', null);
        $db->orderBy('apellido_1');
        
        $out = Array();

        foreach ($res as $row) {
            $p = new Apoderado($row['id']);
            $out[] = $p;
        }
        return $out;            
        
    }
    
}


class ColegioElectoral_Controladora {
    
    var $provincia = null;
    var $municipio = null;
    var $orden = 'votantes';
    
    function getColegios(){
    
        global $db;

        if ($this->provincia) {
            $db->where('left(cp,2)', $this->provincia);
        }
        
        if ($this->municipio) {
            $db->where('municipio', $this->municipio);
        }        

        $res = $db->get('colegios_electorales', null);
        $db->orderBy('nombre');
        
        $out = Array();

        foreach ($res as $row) {
            $p = new ColegioElectoral($row['id']);
            $out[] = $p;
        }
        return $out;        
        
    }
    
    function getMunicipios(){
        global $db;

        if ($this->provincia) {
            $db->where('left(cp,2)', $this->provincia);
        }

        $db->groupBy ("municipio");
        $db->orderBy ("municipio",'ASC');
        
        $res = $db->get('colegios_electorales', null);

        $out = Array();

        foreach ($res as $row) {
            $p = new ColegioElectoral($row['id']);
            $out[] = $p;
        }
        return $out;             
    }
    
}