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

        $email->fromtxt = $id->nombre . " " . $id->apellido_1 . " " . $id->apellido_2;
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

function apoderados_generar_todos() {

    $apoderados = new Apoderados_Controladora();
    $apoderados = $apoderados->getApoderados();

    foreach ($apoderados as $apoderado) {
        echo $apoderado->nombre . " " . $apoderado->apellido_1 . " " . $apoderado->apellido_2 . "<br>";
        apoderados_generar($apoderado->id);
    }
}

function apoderados_generar($id = NULL) {
    global $mod, $c;

    if (!isset($c[2])) {
        exit;
    }

    if (is_null($id)) {
        $id = $c[2];
    }


    $representante = array(
        "AL" => array(
            "nombre" => "María Carmen",
            "apellido_1" => "Martínez",
            "apellido_2" => "García",
            "direccion" => "Carretera de Ronda, 155, Edificio Caracas",
            "num" => "Bajo",
            "cp" => "04005",
            "profesion" => "Oficial Administrativo",
            "municipio" => "Almería",
            "dni" => "77569621M",
            "fecha_nacimiento" => "1979-10-14"
        ),
        "CO" => array(
            "nombre" => "Juan Antonio",
            "apellido_1" => "Alcántara",
            "apellido_2" => "Guerrero",
            "direccion" => "Calle Adarve",
            "num" => "22",
            "cp" => "14001",
            "profesion" => "Ama de Casa",
            "municipio" => "Córdoba",
            "dni" => "44354896V",
            "fecha_nacimiento" => "1976-05-13"
        ),
        "CA" => array(
            "nombre" => "Sandra",
            "apellido_1" => "Alarcón",
            "apellido_2" => "Román",
            "direccion" => "C/ Asta, 1, Residencia Sta. Ana",
            "num" => "Local 2",
            "cp" => "11404",
            "profesion" => "Educadora social",
            "municipio" => "Jerez de la Frontera",
            "dni" => "43130502M",
            "fecha_nacimiento" => "1979-03-07"
        ),
        "HU" => array(
            "nombre" => "Esther Irene",
            "apellido_1" => "Carbajo",
            "apellido_2" => "Delgado",
            "direccion" => "Plaza Noria de Palmarate",
            "num" => "local 2A",
            "cp" => "21003",
            "profesion" => "Ingeniera técnica agrícola",
            "municipio" => "Huelva",
            "dni" => "44217098N",
            "fecha_nacimiento" => "1974-03-05"
        ),
        "GR" => array(
            "nombre" => "Alejandro",
            "apellido_1" => "Cerrada",
            "apellido_2" => "Ferrer",
            "direccion" => "Calle Acera de San Ildefonso",
            "num" => "28",
            "cp" => "18010",
            "profesion" => "Pensionista",
            "municipio" => "Granada",
            "dni" => "77077261Y",
            "fecha_nacimiento" => "1953-01-31"
        ),
        "JA" => array(
            "nombre" => "Irene",
            "apellido_1" => "Reche",
            "apellido_2" => "Gálvez",
            "direccion" => "Calle Doctor Eduardo Arroyo",
            "num" => "11",
            "cp" => "23004",
            "profesion" => "Estudiante",
            "municipio" => "Jaén",
            "dni" => "26250417B",
            "fecha_nacimiento" => "1993-08-14"
        ),
        "MA" => array(
            "nombre" => "Juan Miguel",
            "apellido_1" => "Ruíz",
            "apellido_2" => "García",
            "direccion" => "Plaza Diego Vázquez Otero",
            "num" => "local 3",
            "cp" => "29007",
            "profesion" => "Abogado",
            "municipio" => "Málaga",
            "dni" => "25083438Y",
            "fecha_nacimiento" => "1965-02-25"
        ),
        "SE" => array(
            "nombre" => "Carmen",
            "apellido_1" => "Vera",
            "apellido_2" => "Gómez",
            "direccion" => "Calle León XIII",
            "num" => "20",
            "cp" => "41009",
            "profesion" => "Trabajadora Social",
            "municipio" => "Sevilla",
            "dni" => "75408433N",
            "fecha_nacimiento" => "1961-04-20"
        )
    );

    $apoderado = new Apoderado($id);
    $apoderado->getColegio();
    //var_dump($apoderado);

    $provincia = codigo_to_provincia(substr($apoderado->colegio->CP, 0, 2));

    $data = [
        'de' =>  provincia(codigo_to_provincia(substr($apoderado->colegio->CP,0,2))),
        'Domicilio' => clean($apoderado->direccion),
        'Piso' => clean($apoderado->piso),
        'Municipio' => clean($apoderado->municipio),
        'CP' => clean($apoderado->cp),
        'Provincia' => provincia($apoderado->provincia),
        'NPA4b' => clean($apoderado->nombre . " " . $apoderado->apellido_1 . " " . $apoderado->apellido_2),
        'formacion' => "ADELANTE ANDALUCIA",
        'circunscripcion' => provincia(codigo_to_provincia(substr($apoderado->colegio->CP,0,2))),
        'fecha_eleccion' => clean("2 de diciembre de 2.018"),
        'dni' => clean($apoderado->dni),
        'apellido_2' => clean($apoderado->apellido_2),
        'apellido_1' => clean($apoderado->apellido_1),
        'nombre' => clean($apoderado->nombre),
        'profesion' => clean($apoderado->profesion),
        'edad' => CalculaEdad($apoderado->fecha_nacimiento),
        'num' => clean($apoderado->num),
        'formacion_politica' => clean("ADELANTE ANDALUCIA"),
        'secretario' => "",
        //REPRESENTANTE
        'nombre_2' => clean($representante[$provincia]['nombre']),
        'apellido_1_2' => clean($representante[$provincia]['apellido_1']),
        'apellido_2_2' => clean($representante[$provincia]['apellido_2']),
        'dni_2' => clean($representante[$provincia]['dni']),
        'profesion_2' => clean($representante[$provincia]['profesion']),
        'num_2' => clean($representante[$provincia]['num']),
        'Edad_2' => CalculaEdad($representante[$provincia]['fecha_nacimiento']),
        'Domicilio_2' => clean($representante[$provincia]['direccion']),
        'Piso_2' => "",
        'Municipio_2' => clean($representante[$provincia]['municipio']),
        'CP_2' => clean($representante[$provincia]['cp']),
        'Provincia_2' => provincia($provincia),
    ];



    $pdf_path = BASEAPP . "mods/" . $mod . "/";

    $pdf_path .= 'inc/credencial.pdf';



    $pdf = new Pdf($pdf_path);
    $fichero = str_replace(" ", "_", $apoderado->apellido_1 . "_" . $apoderado->apellido_2 . "_" . $apoderado->nombre);
    $carpeta = BASEAPP . "mods/" . $mod . "/pdf/" . codigo_to_provincia(substr($apoderado->colegio->CP,0,2)) . "/" . $apoderado->colegio->municipio."/";
    $ruta = $carpeta . codigo_to_provincia(substr($apoderado->colegio->CP,0,2)) . str_pad($apoderado->id, 4, "0", STR_PAD_LEFT) . "_" . clean($fichero) . ".pdf";

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    

    if (!file_exists($ruta)) {
        $pdf->fillForm($data)
                ->needAppearances()
                ->saveAs($ruta);
                //->send();
        ;
    }
}

function clean($cadena) {
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    $cadena = utf8_encode($cadena);
    return strtoupper($cadena);
}

function codigo_to_provincia($codigo) {
    $traduce = array(
        "04" => "AL",
        "11" => "CA",
        "14" => "CO",
        "18" => "GR",
        "21" => "HU",
        "23" => "JA",
        "29" => "MA",
        "41" => "SE"
    );
    return $traduce[$codigo];
}

function provincia($abb) {
    $traduce = array(
        "AL" => "ALMERIA",
        "CA" => "CADIZ",
        "CO" => "CORDOBA",
        "GR" => "GRANADA",
        "HU" => "HUELVA",
        "JA" => "JAEN",
        "MA" => "MALAGA",
        "SE" => "SEVILLA",
        "NO" => "OTRA"
    );
    return $traduce[$abb];
}

function CalculaEdad($fecha) {
    list($Y, $m, $d) = explode("-", $fecha);
    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}
