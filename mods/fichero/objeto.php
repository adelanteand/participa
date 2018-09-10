<?php

importclass('usuarios');

class Fichero {

    var $id = 0;

    function Fichero($id) {

        global $db;

        if (is_array($id)) {

            if ($id['size'] > 0) {
                $ext = strtolower(pathinfo($id['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, CONF_UPLOAD_EXTENSIONES)) {
                    return 0;
                }

                if ($id['size'] > (CONF_UPLOAD_MAX * 1024 * 1024)) {
                    return 0;
                }
            }

            //el fichero está validado.
            //lo procesamos y lo registramaos en la bbdd
            if (!file_exists(CONF_UPLOAD_DATA . date("Y") . "/")) {
                mkdir(CONF_UPLOAD_DATA . date("Y") . "/", 0755, true);
            }
            if (!file_exists(CONF_UPLOAD_DATA . date("Y") . "/" . date("m"))) {
                mkdir(CONF_UPLOAD_DATA . date("Y") . "/" . date("m") . "/", 0755, true);
            }
            $rutaNew = CONF_UPLOAD_DATA . date("Y") . "/" . date("m") . "/" . utf8_decode($id['name']);

            $i = 2;
            while (file_exists($rutaNew)) {
                $baseFichero = pathinfo(CONF_UPLOAD_DATA . date("Y") . "/" . date("m") . "/" . utf8_decode($id['name']), PATHINFO_FILENAME);
                $extFichero = pathinfo(CONF_UPLOAD_DATA . date("Y") . "/" . date("m") . "/" . utf8_decode($id['name']), PATHINFO_EXTENSION);
                $rutaNew = CONF_UPLOAD_DATA . date("Y") . "/" . date("m") . "/" . $baseFichero . "-" . $i . "." . $extFichero;
                $i++;
            }

            //move_uploaded_file($id['tmp_name'], $rutaNew);
            copy($id['tmp_name'], $rutaNew);

            

            $id['nombre'] = (pathinfo($rutaNew, PATHINFO_FILENAME) . "." . pathinfo($rutaNew, PATHINFO_EXTENSION));
            $id['filetype'] = $id['type'];
            $id['path'] = $rutaNew;
            $id['usuario'] = null;

            $id = $db->insert('ficheros', $id);
        }

        $db->where('id', $id);
        $row = $db->getOne('ficheros', null, '*');

        if ($db->count > 0) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->filetype = $row['filetype'];
            $this->size = $row['size'];
            $this->path = $row['path'];
            if ($row['usuario']) {
                $this->usuario = new Usuarios(false, $row['usuario']);
            } else {
                $this->usuario = null;
            }
            $this->subida = $row['subida'];
            return 1;
        } else {
            return 0;
        }
    }

}
