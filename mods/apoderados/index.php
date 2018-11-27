<?php

use mikehaertl\pdftk\Pdf;

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
        $mailbody .= "<strong>APELLIDOS: </strong>" . $id->apellido_1 . " " . $id->apellido_2 . "<br>";
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

        $email->fromtxt = $id->nombre . " " . $id->apellido_1 . " " . $id->apellido_2 ;
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

function apoderados_generar() {
    global $mod, $c;

    if (!isset($c[2])) {
        exit;
    }

    $apoderado = new Apoderado($c[2]);

    $data = [
        'de' => $apoderado->nombre,
        'Domicilio' => $apoderado->direccion,
        'Piso' => $apoderado->piso,
        'Municipio' => $apoderado->municipio,
        'CP' => $apoderado->cp,
        'Provincia' => $apoderado->provincia,
        'Edad_2' => $apoderado->fecha_nacimiento,
        'Domicilio_2' => $apoderado->direccion,
        'Piso_2' => $apoderado->piso,
        'Municipio_2' => $apoderado->municipio,
        'CP_2' => $apoderado->cp,
        'Provincia_2' => $apoderado->provincia,
        'NPA4b' => "",
        'formacion' => "ADELANTE ANDALUCIA",
        'circunscripcion' => $apoderado->provincia,
        'fecha_eleccion' => "2 de diciembre de 2.018",
        'apellido_2' => utf8_decode($apoderado->apellido_2),
        'apellido_1' => utf8_decode($apoderado->apellido_1),
        'dni' => $apoderado->dni,
        'nombre' => $apoderado->nombre,
        'profesion' => $apoderado->profesion,
        'edad' => $apoderado->fecha_nacimiento,
        'num' => $apoderado->num,
        'apellido_1_2' => htmlentities($apoderado->apellido_1),
        'apellido_2_2' => htmlentities($apoderado->apellido_2),
        'dni_2' => $apoderado->dni,
        'profesion_2' => $apoderado->profesion,
        'nombre_2' => $apoderado->nombre,
        'num_2' => $apoderado->num,
        'formacion_politica' => "ADELANTE ANDALUCIA",
        'secretario' => "",
    ];



    $pdf_path = BASEAPP . "mods/" . $mod . "/";

    $pdf_path .= 'inc/credencial.pdf';



    $pdf = new Pdf($pdf_path);

    $pdf->fillForm($data)
            ->needAppearances()            
            //->saveAs(BASEAPP . "mods/" . $mod . "/salida.pdf");
            ->send();
            





//    $pdf = new PdfForm($pdf_path . 'inc/credencial.pdf', $data);
    //print_r("<pre>".$pdf->fields()."</pre>");

    /*
      $pdf->flatten()
      ->save('output.pdf')
      ->view();

     */
}
