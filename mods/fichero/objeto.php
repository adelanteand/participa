<?php

importclass('usuarios');

class Fichero {

    var $id = 0;

    function Fichero($id) {

        global $upload_types, $upload_data, $upload_max, $cnx;

        if (is_array($id)) {

            if ($id['size'] > 0) {
                $ext = strtolower(pathinfo($id['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $upload_types)) {
                    return 0;
                }

                if ($id['size'] > ($upload_max * 1024 * 1024)) {
                    return 0;
                }
            }

            //el fichero está validado.
            //lo procesamos y lo registramaos en la bbdd
            if (!file_exists($upload_data . date("Y") . "/")) {
                mkdir($upload_data . date("Y") . "/", 0755, true);
            }
            if (!file_exists($upload_data . date("Y") . "/" . date("m"))) {
                mkdir($upload_data . date("Y") . "/" . date("m") . "/", 0755, true);
            }
            $rutaNew = $upload_data . date("Y") . "/" . date("m") . "/" . utf8_decode($id['name']);

            $i = 2;
            while (file_exists($rutaNew)) {
                $baseFichero = pathinfo($upload_data . date("Y") . "/" . date("m") . "/" . utf8_decode($id['name']), PATHINFO_FILENAME);
                $extFichero  = pathinfo($upload_data . date("Y") . "/" . date("m") . "/" . utf8_decode($id['name']), PATHINFO_EXTENSION);
                $rutaNew     = $upload_data . date("Y") . "/" . date("m") . "/" . $baseFichero . "-" . $i . "." . $extFichero;
                $i++;
            }

            //move_uploaded_file($id['tmp_name'], $rutaNew);
            copy($id['tmp_name'], $rutaNew);            

            //limpiamos los campos y valores no presentes en el formulario para generar una consulta SQL limpia
            $campos = array( 'nombre', 'filetype', 'size', 'path', 'usuario');
            $campo_id = array('id');
            
            $id['nombre']=(pathinfo($rutaNew, PATHINFO_FILENAME) . "." . pathinfo($rutaNew, PATHINFO_EXTENSION)) ;
            $id['filetype']=$id['type'];
            $id['path']=$rutaNew;
            $id['usuario']=$id['usuario'];
            
            
            foreach ($campos as $campo) {
                if (!isset($id[$campo])) {
                    $id[$campo] = "NULL";
                } else {
                    if (isset($id[$campo]) && $id[$campo] != "")
                        if (ctype_digit($id[$campo])) {
                            if (($id[$campo] == 0))
                                $id[$campo] = 'NULL';
                            else
                                $id[$campo] = addslashes($id[$campo]);
                        } else
                            $id[$campo] = "'" . addslashes($id[$campo]) . "'";
                    else
                        $id[$campo] = "NULL";
                }
            }

            $sql = "INSERT INTO ficheros SET ";
            foreach ($campos as $campo) {
                $sql .= "$campo = " . $id[$campo] . ", ";
            }
            foreach ($campo_id as $campo) {
                $sql .= "$campo = NULL, ";
            }
            $sql = rtrim($sql, ', ');            
            
           var_dump($sql);
            print_r($sql);
            mysqli_query($cnx, $sql);
            $id    = mysqli_insert_id($cnx);                        
            $id = mysqli_insert_id($cnx);
        }

        $sql = "
             SELECT 
                id, nombre, filetype, size, path, usuario, subida
             FROM 
                ficheros
             WHERE        
                id=" . (int) $id;

        $res = mysqli_query($cnx, $sql);

        if ($row = mysqli_fetch_array($res)) {
            $this -> id       = $row['id'];
            $this -> nombre   = $row['nombre'];
            $this -> filetype = $row['filetype'];
            $this -> size     = $row['size'];
            $this -> path     = $row['path'];
            $this -> usuario  = new Usuarios(false, $row['usuario']);
            $this -> subida   = $row['subida'];
        }
    }

}
