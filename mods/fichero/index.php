<?php

if ($op == "download") {

    $f        = new Fichero($subop);
    $file_url = $f -> path;
    $size     = filesize($file_url);
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-length: $size");
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
    readfile($file_url); // do the double-download-dance (dirty but worky)    
}
