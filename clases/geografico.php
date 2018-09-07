<?php

class Lugar {

    var $id = 0;

    function Lugar($tipo, $id, $superior = null) {
        global $cnx;
        if (is_array($id)) {
            //es un array, lo tratamos como nuevo y una inserción.
            //TODO: insertar expediente
        }

        switch ($tipo) {
            case 'municipio' :
                $sql            = "select id_provincia,id_municipio,municipio from geo_Municipios where id_municipio = $id and id_provincia = $superior";
                $campo_id       = "id_municipio";
                $campo_nombre   = "municipio";
                $campo_superior = "id_provincia";
                $tipo_superior  = "provincia";
                break;

            case 'provincia' :
                $sql            = "select id,provincia,id_ccaa from geo_Provincias where id = $id";
                $campo_id       = "id";
                $campo_nombre   = "provincia";
                $campo_superior = "id_ccaa";
                $tipo_superior  = "comunidad";
                break;

            case 'comunidad' :
                $sql            = "select id,comunidad from geo_CCAA where id = $id";
                $campo_id       = "id";
                $campo_nombre   = "comunidad";
                $campo_superior = NULL;
                $tipo_superior  = NULL;
                break;
        }

        $res = mysqli_query($cnx, $sql);
        //var_dump($sql);
        if ($row = mysqli_fetch_array($res)) {
            $this -> id       = $row[$campo_id];
            $this -> nombre   = utf8_encode($row[$campo_nombre]);
            if ($tipo_superior !== NULL)
                $this -> superior = new Lugar($tipo_superior, $row[$campo_superior]);
            else
                $this -> superior = NULL;
        }
    }

}

class Geografia {

    function getCCAA() {
        global $cnx;
        $out = Array();

        $sql = "select id, comunidad from geo_CCAA order by comunidad";

        $res = mysqli_query($cnx, $sql);
        $out = Array();
        while ($row = mysqli_fetch_array($res)) {
            $p     = new Lugar("comunidad", $row['id']);
            $out[] = $p;
        }
        return $out;
    }

    function getProvincias($ccaa = "1") {
        global $cnx;
        $out = Array();

        if ($ccaa === NULL || $ccaa == 0)
            $where = "";
        else
            $where = "AND id_ccaa = $ccaa";

        $sql = "select id, provincia, id_ccaa from geo_Provincias where 1 $where order by provincia";

        $res = mysqli_query($cnx, $sql);
        $out = Array();
        while ($row = mysqli_fetch_array($res)) {
            $p     = new Lugar("provincia", $row['id']);
            $out[] = $p;
        }

        return $out;
    }

    function getMunicipios($provincia) {
        global $cnx;
        $out = Array();

        if ($provincia === NULL || $provincia == 0)
            exit;
        else
            $where = "AND id_provincia = $provincia";

        $sql = "select id_municipio, municipio, id_provincia from geo_Municipios where 1 $where order by municipio";
        //var_dump($sql);
        $res = mysqli_query($cnx, $sql);
        $out = Array();
        while ($row = mysqli_fetch_array($res)) {
            $p     = new Lugar("municipio", $row['id_municipio'], $row['id_provincia']);
            $out[] = $p;
        }


        return $out;
    }

}

class Provincia {

    var $id = 0;

    function __construct($id) {
        global $cnx;

        if (is_array($id)) {
            //es un array, lo tratamos como nuevo y una inserción.
            //TODO: insertar expediente
        }

        $sql = "select id, nombre from provincia where id = '$id'";
        //var_dump($sql);
        $res = mysqli_query($cnx, $sql);

        if ($row = mysqli_fetch_array($res)) {
            $this -> id     = $row['id'];
            $this -> nombre = utf8_encode($row['nombre']);
        }
    }

    function __toString() {
        if (!is_null($this -> nombre))
            return $this -> nombre;
        else
            return "";
    }

}

class Provincia_Controlador {

    var $id = 0;

    function getProvincias() {

        global $cnx;
        $sql = "select id, nombre from provincia order by id";
        $res = mysqli_query($cnx, $sql);
        $out = array();
        while ($row = mysqli_fetch_array($res)) {
            $p     = new Provincia($row['id']);
            $out[] = $p;
        }
        return $out;
    }

}
