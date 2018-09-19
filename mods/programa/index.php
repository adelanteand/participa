<?php

if (isset($c)) {
    call_user_func(callFuncionParametros($c));
} else {
    call_user_func('programa');
}

function programa_off() {
    global $html;

    $html->asignar("msg", "Estamos ajustando la página. Volvemos en unos minutos.");
    $html->plantilla("error.tpl");
    $html->ver();
}

function programa() {
    global $html;

    $html->asignar("version", "default");

    $cats = new Programa_Categoria_Controladora();

    $res = $cats->getCategorias();
    $lista = $cats->getLista($res);
    $divs = $cats->getDIVS($res);

    $html->asignar("ip", getIPv4());
    $html->asignar("programa", $divs);
    $html->plantilla("index.tpl");
    $html->ver();
}

function formulario() {
    global $html, $op, $subop;

    $html->asignar("version", "patios");
    $html->asignar("ip", getIPv4());

    switch ($op) {
        case 'add':
        case 'sup':
        case 'mod':
            $accion = $op;
            break;
        default:
            $html->asignar("msg", "No existe la acción indicada");
            $html->plantilla("error.tpl");
            $html->ver();
            exit;
    }

    $elementotipo = 'propuesta';
    if ($accion == 'add') {
        $categoria = new Programa_Categoria($subop);
        if (!($categoria->existe)) {
            $html->asignar("msg", "No existe la categoría indicada");
            $html->plantilla("error.tpl");
            $html->ver();
            exit;
        }
        $html->asignar("categoria", $categoria);
    }

    if ($accion == 'mod' || $accion == 'sup') {
        $propuesta = new Programa_Propuesta($subop);
        if (!$propuesta->existe) {
            $html->asignar("msg", "No existe la propuesta indicada");
            $html->plantilla("error.tpl");
            $html->ver();
            exit;
        }
        $html->asignar("elemento", $propuesta);
        if ($propuesta->tipo == 'propuesta') {
            $elementotipo = 'propuesta';
        } else {
            $elementotipo = 'párrafo';
        }
    }

    $html->asignar("op", $op);
    if (isset($_SERVER['HTTP_REFERER'])) {
        $url_anterior = $_SERVER['HTTP_REFERER'];
    } else {
        $url_anterior = "javascript:window.history.back();";
    }
    $html->asignar("url_anterior", $url_anterior);
    $html->asignar("elementotipo", $elementotipo);
    $html->asignar("accion", $accion);

    $html->plantilla("formulario.tpl");
    $html->ver();
}

function propuesta($tipo = 'Propuesta') {
    global $op, $html;

    $html->asignar("version", "patios");
    $html->asignar("tipo", $tipo);

    $propuesta = new Programa_Propuesta($op);

    if (!$propuesta->existe) {
        $html->asignar("msg", "No existe la propuesta indicada");
        $html->plantilla("error.tpl");
        $html->ver();
        exit;
    }

    if ($propuesta->tipo == 'propuesta') {
        $elementotipo = 'propuesta';
    } else {
        $elementotipo = 'párrafo';
    }

    $tienePadre = true;
    $padres = array();
    $categoria = $propuesta->cat;
    while ($tienePadre) {
        //var_dump($categoria);
        if (isset($categoria->padre->id)) {
            $padres[] = $categoria->padre;
            $categoria = $categoria->padre;
        } else {
            $tienePadre = false;
        }
    }
    $padres = array_reverse($padres);
    //var_dump($padres);
    //var_dump($propuesta);

    $in = strip_tags($propuesta->texto);
    $propuesta->textoplano = Html2Text\Html2Text::convert($propuesta->texto);
    $propuesta->textoplano = preg_replace("/\r|\n/", "", $propuesta->textoplano);
    $propuesta->acortada = strlen($in) > 220 ? substr($in, 0, 220) . "..." : $in;
    $html->asignar("ip", getIPv4());
    $html->asignar("elementotipo", $elementotipo);
    if (isset($_SERVER['HTTP_REFERER'])) {
        $url_anterior = $_SERVER['HTTP_REFERER'];
    } else {
        $url_anterior = "javascript:window.history.back();";
    }
    $html->asignar("url_anterior", $url_anterior);
    $html->asignar("propuesta", $propuesta);
    $html->asignar("actual", $propuesta->cat);
    $html->asignar("padres", $padres);
    $html->titulo('Propuesta ' . $propuesta->id . CONF_TITULOPAGINA_POS);
    $html->descripcion($propuesta->texto);
    $propuesta->getEnmiendas();
    $html->plantilla("propuesta.tpl");
    $html->ver();
}

function categoria() {
    global $html, $c, $op;

    $html->asignar("version", "patios");

    if (isset($c[1])) {
        $id = $c[1];
    } else {
        $id = 0;
    }

    $tienePadre = true;
    $padres = array();
    $categoria = new Programa_Categoria($op);
    while ($tienePadre) {
        //var_dump($categoria);
        if (isset($categoria->padre->id)) {
            $padres[] = $categoria->padre;
            $categoria = $categoria->padre;
        } else {
            $tienePadre = false;
        }
    }

    $categoria = new Programa_Categoria($op);
    $categoria->getIntro();
    $padres = array_reverse($padres);

    if (isset(end($padres)->id)) {
        $anterior = end($padres)->id;
    } else {
        $anterior = 'ROOT';
    }
    $hijos = new Programa_Categoria_Controladora();
    $propuestas = new Programa_Propuesta_Controladora();
    $propuestas = $propuestas->getPropuestasCategoria($categoria->id);
    $html->asignar("ip", getIPv4());
    $html->asignar("categoria", $categoria);
    $html->asignar("propuestas", $propuestas);
    $html->asignar("actual", $categoria);
    $html->asignar("anterior", $anterior);
    $html->asignar("padres", $padres);
    $html->asignar("hijos", $hijos->getNivel($categoria->id));
    $categoria->getEnmiendas();
    $html->plantilla("nivel.tpl");
    $html->ver();
}

function patios() {
    categoria();
}

function parrafo() {
    propuesta('Párrafo');
}

function patios_listado() {
    global $html;
    $html->asignar("version", "patios");
    $html->plantilla("patios_listado.tpl");
    $html->ver();
}

function pdf() {
    echo "Disponible próximamente.";
}

function enviar() {
    global $db;


    if ($_FILES) {
        $_POST['fichero'] = $_FILES; //añadimos a POST lo enviado por FILES
    } else {
        $_POST['fichero'] = null;
    }

    $id = new Programa_Enmienda($_POST);

    if ($id) {

        $email = new Correo();
        $html = "";

        switch ($id->tipo) {
            case 'sup': $tipo = "SUPRESIÓN " . $id->idPropuesta->id;
                break;
            case 'add': $tipo = "ADICIÓN";
                break;
            case 'mod': $tipo = "MODIFICACIÓN " . $id->idPropuesta->id;
                break;
        }

        $html .= "<strong>ID ENMIENDA: </strong>" . $id->id . "<br>";
        $html .= "<strong>TIPO: </strong>" . $tipo . "<br>";
        $html .= "<strong>PROPUESTA Nº: </strong>" . $id->idPropuesta->id . "<br>";
        $html .= "<strong>CATEGORIA: </strong>" . $id->idCategoria->id . "<br>";
        $html .= "<strong>CATEGORIA NOMBRE: </strong>" . $id->idCategoria->nombre . "<br>";
        $html .= "<strong>NOMBRE: </strong>" . $id->nombre . "<br>";
        $html .= "<strong>APELLIDOS: </strong>" . $id->apellidos . "<br>";
        $html .= "<strong>CP: </strong>" . $id->cp->cp . "<br>";
        $html .= "<strong>EMAIL: </strong>" . $id->email . "<br>";
        $html .= "<strong>TELEFONO: </strong>" . $id->telefono . "<br>";
        $html .= "<strong>VALIDAR: </strong> <a href=" . CONF_BASEURL . "enmienda/validar/" . $id->id . "/" . $id->random . "/>Validar ahora</a><br>";
        $html .= "<strong>MOTIVACION: </strong><br>" . $id->motivacion . "<br><br>";
        $html .= "<strong>REDACCION: </strong>" . $id->redaccion . "<br>";

        if (property_exists($id->idPropuesta, 'texto')) {
            $html .= "<hr>";
            $html .= $id->idPropuesta->texto;
        }

        if (property_exists($id, 'fichero') && $id->fichero) {
            $email->adjunto = $id->fichero;
        }

        $email->fromtxt = $id->nombre . " " . $id->apellidos;
        $email->asunto = "ENMIENDA " . ($tipo);
        $email->from = MAIL_ADMIN;
        $email->to = MAIL_ENMIENDAS;
        $email->enviar($html);
        //var_dump($id);        
    }
}

function enmienda_validar() {
    global $html, $c;
    $html->asignar("version", "patios");

    $enmienda = new Programa_Enmienda($c[2]);
    if ($c[3] == $enmienda->random) {
        $id['publica'] = 1;
        $enmienda->editar($id);
        $accion = "OK";
    } else {
        $accion = "NO";
    }
    $html->asignar("accion", $accion);
    $html->plantilla("validar_enmienda.tpl");
    $html->ver();
}

function enmienda() {
    global $op, $html;

    $html->asignar("version", "patios");

    $enmienda = new Programa_Enmienda($op);

    if (!$enmienda->existe) {
        $html->asignar("msg", "No existe la enmienda indicada");
        $html->plantilla("error.tpl");
        $html->ver();
        exit;
    }

    $fichero = null;
    if ($enmienda->fichero) {
        importclass("fichero");
        $fichero = new Fichero($enmienda->fichero);
    }

    $html->asignar("fichero", $fichero);
    $html->asignar("url", CONF_BASEURL);
    $html->asignar("e", $enmienda);
    $html->plantilla("enmienda_web.tpl");
    $html->ver();
}

function enmiendas_provincias() {

    global $html;

    $provincias = array(
        "Almería" => "04",
        "Cádiz" => "11",
        "Córdoba" => "14",
        "Granada" => "18",
        "Huelva" => "21",
        "Málaga" => "29",
        "Jaén" => "23",
        "Sevilla" => "41"
    );

    $codEnmiendas = new Programa_Enmienda_Controladora();
    foreach ($provincias as $prov => $codprov) {
        $resultado = $codEnmiendas->getEnmiendasProvincia($codprov);
        $tabla[$prov] = sizeof($resultado);
    }
    $html->asignar("version", "patios");
    $html->asignar("tabla", $tabla);
    $html->plantilla("enmiendas_provincias.tpl");
    $html->ver();
}

function patio_inscripcion() {

    global $html, $c, $op, $subop;
    importclass("geografico");
    $html->asignar("version", "patios");
    $patio = new Patio_Evento($subop);
    if (!$patio->existe) {
        $html->asignar("msg", "No existe el patio indicado");
        $html->plantilla("error.tpl");
        $html->ver();
        exit;
    }
    $ejes = new Programa_Categoria_Controladora();
    $ejes = $ejes->getNivel(0);

    //MOSTRAR PLANTILLA
    if (isset($_SERVER['HTTP_REFERER'])) {
        $url_anterior = $_SERVER['HTTP_REFERER'];
    } else {
        $url_anterior = "javascript:window.history.back();";
    }
    $html->asignar("url_anterior", $url_anterior);

    $html->asignar("patio", $patio);
    $html->asignar("ejes", $ejes);
    $html->asignar("ip", getIPv4());
    $html->plantilla("patio_inscripcion.tpl");
    $html->ver();
}

function patio_inscripcion_enviar() {
    global $db;

    $_POST['ejes'] = implode($_POST['ejes'], ",");
    $id = new Patio_Inscripcion($_POST);
    
    $id->ejes = explode(",",$id->ejes);
    $tmpejes = array();
    foreach ($id->ejes as $eje){
        $tmpejes[] = new Programa_Categoria($eje);        
    }
    $id->ejes = $tmpejes;

    if ($id) {

        $email = new Correo();
        $html = "";

        $html .= "<strong>ID: </strong>" . $id->id . "<br>";
        $html .= "<strong>PATIO: </strong>" . $id->patio->ciudad . "<br>";
        $html .= "<strong>NOMBRE: </strong>" . $id->nombre . "<br>";
        $html .= "<strong>APELLIDOS: </strong>" . $id->apellidos . "<br>";
        $html .= "<strong>CP: </strong>" . $id->cp->cp . " " . $id->cp->municipio . "<br>";
        $html .= "<strong>EMAIL: </strong>" . $id->email . "<br>";
        $html .= "<strong>TELEFONO: </strong>" . $id->telefono . "<br>";
        $html .= "<strong>LUDOTECA: </strong>" . (($id->ludoteca) ? "Sí" : "No") . "<br>";
        $html .= "<strong>OBSERVACIONES: </strong>" . $id->observaciones . "<br>";
        $html .= "<strong>EJES: </strong><br>";
        
        foreach ($id->ejes as $eje){
            $html .= "- " . $eje->id . " " . $eje->nombre."<br>";
        }

        echo $html;
        $email->fromtxt = $id->nombre . " " . $id->apellidos;
        $email->asunto = "INSCRIPCION PATIO: " . $id->patio->ciudad;
        $email->from = MAIL_ADMIN;
        $email->to = MAIL_ENMIENDAS;
        $email->enviar($html);
        //var_dump($id);        
    }
}
