<?php

if (isset($c)) {
    call_user_func(callFuncionParametros($c));
} else {
    call_user_func('programa');
}

function programa() {
    global $html;


    $cats = new Programa_Categoria_Controladora();
    $getPropuestas = true;
    $res = $cats->getCategorias($getPropuestas);
    $lista = $cats->getLista($res, $getPropuestas);
    $divs = $cats->getDIVS($res, $getPropuestas);

    $html->asignar("ip", getIPv4());
    $html->asignar("programa", $divs);
    $html->plantilla("index.tpl");
    $html->ver();
}

function patio() {
    global $html, $c;

    if (isset($c[1])) {
        $id = $c[1];
    } else {
        $id = 0;
    }
    $cats = new Programa_Categoria_Controladora();
    $cats = $cats->getNivel($id);
    $padre = new Programa_Categoria($id);
    if ($padre->existe) {
        if ($padre->padre->id) {
            $anterior = $padre->padre->id;
        } else {
            $anterior = "ROOT";
        }
    } else {
        $anterior = NULL;
    }

    $propuestas = NULL;

    if (!$cats) {
        $propuestas = new Programa_Propuesta_Controladora();
        $propuestas = $propuestas->getPropuestasCategoria($id);
    }

    $html->asignar("propuestas", $propuestas);
    $html->asignar("anterior", $anterior);
    $html->asignar("cats", $cats);
    $html->plantilla("nivel.tpl");
    $html->ver();
}

function pdf() {
    echo "Disponible próximamente.";
}

function enviar() {
    /**
    importclass("fichero");
    if ($_FILES) {
        $_POST['fichero'] = $_FILES; //añadimos a POST lo enviado por FILES
    } else {
        $_POST['fichero'] = null;
    }
    $ficheros = $_POST['fichero'];

    foreach ($ficheros as $fichero) {
        if ($fichero['size'] > 0) {
            $fichero = new Fichero($fichero);
        }
    }
    var_dump($fichero);
     * */    
    //var_dump($_POST);
    $id = new Programa_Enmienda($_POST);
    
    if ($id) {

        $email = new Correo();
        $html = "";

        $html .= "<strong>TIPO: </strong>".$id->tipo."<br>";
        $html .= "<strong>PROPUESTA: </strong>".$id->idPropuesta->id."<br>";
        $html .= "<strong>CATEGORIA: </strong>".$id->idCategoria->id."<br>";
        $html .= "<strong>NOMBRE: </strong>".$id->nombre."<br>";
        $html .= "<strong>APELLIDOS: </strong>".$id->apellidos."<br>";
        $html .= "<strong>CP: </strong>".$id->cp."<br>";
        $html .= "<strong>EMAIL: </strong>".$id->email."<br>";
        $html .= "<strong>TELEFONO: </strong>".$id->telefono."<br>";
        $html .= "<strong>MOTIVACION: </strong><br>".$id->motivacion."<br><br>";
        $html .= "<strong>REDACCION: </strong>".$id->redaccion."<br>";

        $email->asunto="ENMIENDA " . $id->tipo;
        $email->from="soporte@adelanteandalucia.org";
        $email->to="acf@yingo.es";
        $email->enviar($html);
        //var_dump($id);        
        
    }
    

}
