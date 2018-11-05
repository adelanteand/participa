<?php

if (isset($c)) {
    call_user_func(callFuncionParametros($c));
} else {
    call_user_func('index');
}

function apoderadas() {
    call_user_func('apoderados');
}

function apoderadas_apuntate() {
    call_user_func('apoderados_apuntate');
}

function apoderados() {
/**
    $colegios = new ColegioElectoral_Controladora();
    //$colegios->provincia=04;
    $listado = $colegios->getColegios();
    var_dump($listado);
 * 
 */
    
    global $html;
    $html->asignar("msg", "Acceso incorrecto");
    $html->plantilla("error.tpl");
    $html->ver();
}

function apoderados_apuntate() {
    global $html, $css, $js;

    $css[] = CONF_BASEURL . "vendor/select2/dist/css/select2.min.css";
    $css[] = CONF_BASEURL . "vendor/leaflet/dist/leaflet.css";
    $css[] = CONF_BASEURL . "vendor/leaflet.markercluster/dist/MarkerCluster.css";
    $css[] = CONF_BASEURL . "vendor/leaflet.markercluster/dist/MarkerCluster.Default.css";
    $css[] = CONF_BASEURL . "vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.standalone.min.css";

    $js[] = CONF_BASEURL . "vendor/select2/dist/js/select2.full.min.js";
    $js[] = CONF_BASEURL . "vendor/select2/dist/js/i18n/es.js";
    $js[] = CONF_BASEURL . "vendor/leaflet/dist/leaflet.js";
    $js[] = CONF_BASEURL . "vendor/leaflet.markercluster/dist/leaflet.markercluster.js";
    $js[] = CONF_BASEURL . "vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js";
    $js[] = CONF_BASEURL . "vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js";

    $html->assign("css", $css);
    $html->assign("js", $js);

    $listado = new ColegioElectoral_Controladora();
    $colegios = $listado->getColegios();
    $html->assign("marcadores", $colegios);

    $html->plantilla("apuntate.tpl");
    $html->ver();
}

function apoderados_enviar() {
    global $mod, $html;
    $_POST['envio'] = date("d/m/Y H:i:s");
    //var_dump($_POST);
    //ajustamos POST
    $_POST['colegio_provincia'] = $_POST['provincia'];
    $_POST['colegio_municipio'] = $_POST['municipio'];
    $_POST['provincia'] = $_POST['dirprovincia'];
    $_POST['municipio'] = $_POST['dirmunicipio'];
    $_POST['dni'] = $_POST['DNI'];
    $date = DateTime::createFromFormat('d/m/Y H:i:s', $_POST['fecha_nacimiento'] . ' 00:00:00');
    $_POST['fecha_nacimiento'] = $date->format('Y-m-d H:i:s');

    $id = new Apoderado($_POST);
    //var_dump($insertado);

    $fichero = BASEAPP . 'mods/' . $mod . "/envios.txt";
    $fh = fopen($fichero, 'a');
    fwrite($fh, print_r($_POST, true));
    fclose($fh);

    if ($id->existe) {

        $email = new Correo();
        $mailbody = "";

        $mailbody .= "Hemos recibido correctamente tus datos. Nos pondremos en contacto contigo. Muchas gracias <br><hr>";
        $mailbody .= "<strong>ID: </strong>" . $id->id . "<br>";
        $mailbody .= "<strong>NOMBRE: </strong>" . $id->nombre . "<br>";
        $mailbody .= "<strong>APELLIDOS: </strong>" . $id->apellidos . "<br>";
        $mailbody .= "<strong>GÉNERO: </strong>" . $id->genero . "<br>";
        $mailbody .= "<strong>EMAIL: </strong>" . $id->email . "<br>";
        $mailbody .= "<strong>TELEFONO: </strong>" . $id->telefono . "<br>";
        $mailbody .= "<strong>DNI: </strong>" . $id->dni . "<br>";
        $mailbody .= "<strong>FECHA NACIMIENTO: </strong>" . $id->fecha_nacimiento . "<br>";
        $mailbody .= "<strong>MOVILIDAD REDUCIDA: </strong>" . $id->movilidad . "<br>";
        $mailbody .= "<strong>PROFESIÓN: </strong>" . $id->profesion . "<br>";
        $mailbody .= "<strong>PROVINCIA: </strong>" . $id->provincia . "<br>";
        $mailbody .= "<strong>MUNICIPIO: </strong>" . $id->municipio . "<br>";
        $mailbody .= "<strong>DIRECCIÓN: </strong>" . $id->direccion . "<br>";
        $mailbody .= "<strong>NÚMERO: </strong>" . $id->num . "<br>";
        $mailbody .= "<strong>PISO: </strong>" . $id->piso . "<br>";
        $mailbody .= "<strong>CP: </strong>" . $id->cp . "<br>";
        $mailbody .= "<strong>COLEGIO: </strong>" . $id->colegio . "<br>";
        $mailbody .= "<strong>CAMBIO COLEGIO: </strong>" . $id->disponibilidad . "<br>";
        $mailbody .= "<strong>VOLUNTARIO: </strong>" . $id->voluntario . "<br>";
        $mailbody .= "<strong>OBSERVACIONES: </strong>" . $id->observaciones . "<br>";
        $mailbody .= "<strong>TOKEN: </strong>" . $id->token . "<br>";

        $email->fromtxt = $id->nombre . " " . $id->apellidos;
        $email->asunto = "Inscricipón APODERADO/A " . ($id->provincia);
        $email->from = MAIL_ADMIN;
        $email->to = MAIL_ENMIENDAS;
        $email->to = $id->email;
        ;
        $email->enviar($mailbody);
        //var_dump($id);        

        $html->plantilla("apuntate_ok.tpl");
        
    } else {

        $html->plantilla("apuntate_error.tpl");
    }
    
    $html->ver();
}
