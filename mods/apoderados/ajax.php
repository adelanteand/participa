<?php

if ($op == "selectProvincia") {
    $colegios = new ColegioElectoral_Controladora();
    $colegios->provincia = $_POST['provincia'];
    $listado = $colegios->getMunicipios();
    echo json_encode($listado);
}


if ($op == "selectMunicipio") {
    if ($_POST['municipio'] != "") {
        $colegios = new ColegioElectoral_Controladora();
        $colegios->municipio = $_POST['municipio'];
        $listado = $colegios->getColegios();
        echo json_encode($listado);
    }
}

if ($op == "getColegios") {
    $colegios = new ColegioElectoral_Controladora();
    $listado = $colegios->getColegios();
    echo json_encode($listado);
}