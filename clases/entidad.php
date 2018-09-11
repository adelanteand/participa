<?php

importclass("media", BASEAPP);

Abstract Class Entidad {

    /**
     * 
     * @param type $id
     * @param type $datos
     */
    function __construct($id, $datos) {
        global $db;
        $datos = $this->setData($datos);
        
        if (is_array($id)) {
            //Lo consideramos un registros a crear en la base de datos
            $id = $this->insert($id, $datos);
            //print_r($db->getLastQuery());
        }
        $this->id = $id;
        //Seleccionamos el registro creado o especificado
        if ($this->select($id, $datos)) {
            $this->existe = true;
            return 1;
        } else {
            $this->existe = false;
            return 0;
        }
    }

    /**
     * Devuelve valores por defecto en caso de no ser suminsitrados
     * @param type $datos
     * @return type
     */
    function setData($datos) {

        $out = array();

        $out['tabla'] = null;
        $out['manuales'] = array();
        $out['fk'] = array();
        $out['mysql'] = array('created_at');
        $out['id'] = array('id');
        $out['pwd'] = array();
        $out['file'] = array();

        foreach ($out as $campo => $val) {
            if (isset($datos[$campo])) {
                $out[$campo] = $datos[$campo];
            }
        }

        $out['campos'] = array_unique(
                array_merge(
                        $out['id'], $out['manuales'], $out['mysql'], $out['pwd'],$out['file']
                )
        );

        return $out;
    }

    /**
     * Inserta un registro en la base de datos
     * @global type $db
     * @param array $id
     */
    function insert($id, $datos) {

        global $db;

        $valores = array();
        foreach ($datos['id'] as $campo) {
            if (isset($id[$campo])) {
                $valores[$campo] = $id[$campo];
            } else {
                $valores[$campo] = NULL;
            }
        }

        foreach ($datos['manuales'] as $campo) {
            if (!isset($id[$campo])) {
                $id[$campo] = NULL;
            } else {
                if (isset($id[$campo]) && $id[$campo] != "") {
                    if (ctype_digit($id[$campo])) {
                        if (array_key_exists($campo, $datos['fk']) && ($id[$campo] == 0)) {
                            $id[$campo] = NULL;
                        } else {
                            $id[$campo] = addslashes($id[$campo]);
                        }
                    } else {
                        $id[$campo] = addslashes($id[$campo]);
                    }
                } else {
                    $id[$campo] = NULL;
                }
            }
        }
        
        foreach ($datos['manuales'] as $campo) {
            if ($id[$campo] == 'NULL') {
                $valores[$campo] = NULL;
            } else {
                $valores[$campo] = $id[$campo];
            }
        }

        foreach ($datos['pwd'] as $campo) {
            $valores[$campo] = password_hash($id[$campo], PASSWORD_DEFAULT);
        }
        
        foreach ($datos['file'] as $campo) {
            $ficheros = $id[$campo] ;
            foreach ($ficheros as $file) {
                if ($file['size'] > 0) {
                    $fichero = new Fichero($file);
                }
                if (isset($fichero->id)) {
                    $valores[$campo] = $fichero->id;
                }
            }
        }
        
        return $db->insert($datos['tabla'], $valores);
    }

    /**
     * Selecciona un registro en la base de datos
     * @global type $db
     * @param type $id
     */
    function select($id, $datos) {
        global $db;

        $db->where($datos['id'][0], $id);
        //var_dump($id);
        $row = $db->getOne($datos['tabla'], null, $datos['campos']);

        if ($db->count > 0) {
            //asignamos valores al objeto obtenidos de la base de datos
            foreach ($datos['campos'] as $campo) {
                $this->$campo = $row[$campo];
            }
            //creamos las instancias de los elementos vinculados si hubiera
            foreach ($datos['fk'] as $campo => $valor) {
                $this->$campo = new $valor($row[$campo]);
            }
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Los datos con los que actualizar el registro se encuentran en $id
     * Los datos sobre la base de datos se encuentran en $datos
     * @global type $db
     * @param type $id
     * @param type $datos
     * @return int
     */
    function edit($id, $datos) {

        global $db, $mod;

        if (is_array($id) && $this->id != 0) {

            $valores = array();
            foreach ($datos['manuales'] as $campo) {
                if (isset($id[$campo])) {
                    $valores[$campo] = $id[$campo];
                }
            }

            foreach ($datos['pwd'] as $campo) {
                if (isset($id[$campo])) {
                    $valores[$campo] = password_hash($id[$campo], PASSWORD_DEFAULT);
                }
            }

            if (array_key_exists('image', $id)) {
                $ficheros = $id['image'];
                foreach ($ficheros as $fichero) {
                    if ($fichero['size'] > 0) {
                        $new = CrearMediaFromImagen($fichero['tmp_name'], $mod, $this->id);
                    }
                }
            }


            $db->where('id', $this->id);
            if ($db->update($datos['tabla'], $valores)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            exit("Se requiere array de datos y un objeto seleccionado !=0");
        }
    }

    /**
     * Elimina registro en la base de datos
     * @global type $db
     * @param type $id
     * @param type $datos
     * @return int
     */
    function remove($datos) {
        global $db;
        $db->where('id', $this->id);
        if ($db->delete($datos['tabla'])) {
            return 1;
        } else {
            return 0;
        }
    }

}
