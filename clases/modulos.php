<?php

class Modulo extends Entidad {

    var $id = 0;
    private $datos = array(
        'tabla' => "modulos",
        'manuales' => array(
            'titulo',
            'menu',
            'descripcion',
            'publico',
            'enlace',
            'orden',
            'icono'
        ),
        'id' => array('modulo')
    );

    function __construct($id = 0) {
        $res = parent::__construct($id, $this->datos);
        if (!$this->existe) {
            $datos = array (
                'modulo' => $id,
                'titulo' => $id,
                'descripcion', null,
                'menu' => '0',                
                'publico' => '0',
                'enlace' => '/'.$id.'/',
                'orden' => null,
                'icono' => null
            );
            parent::__construct($datos, $this->datos);
        }
    }

}
