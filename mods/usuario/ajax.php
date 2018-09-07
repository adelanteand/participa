<?php

importclass("media");

call_user_func(callFuncionParametros($c));

function ajax_usuario_eliminar_imagen() {
    global $usuario;
    
    if ($usuario->id == 0) {
        exit;
    }
    $out = Array();
    $media = new Media($_POST['id']);
    $out[0] = $media->delete();
    echo json_encode($out);
}
