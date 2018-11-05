<?php

if (isset($c)) {
    call_user_func(callFuncionParametros($c));
} else {
    call_user_func('index');
}

function index() {
    var_dump("Eleeciones 2D");
}
