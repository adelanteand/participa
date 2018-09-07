<?php

call_user_func(callFuncionParametros($c));

function usuario() {
    global $html, $usuario, $mod;
    $html -> asignar("titulo", "Mi usuario");
    $html -> botones("index.botones.tpl");

    if ($media = GetMediaFromModulo($mod, $usuario -> id)) {
        $html -> asignar("media", $media);
    }
    $html -> plantilla("index.tpl");
    $html -> ver();
    //var_dump($usuario);
}

function usuario_login() {
    global $html;
    $html -> plantilla("login.tpl");
    $html -> ver();
}

function usuario_salir() {
    global $usuario;
    $usuario -> salir();
    exit;
}

function usuario_setpwd() {
//    global $usuario;
//    $u = new Usuario(1);
//    $u->setpwd('123');    
//    exit('cambiado');
}

function usuario_entrar() {
    global $html;

    $usuario = new Usuario();
    $msg     = array();

    if ($usuario -> comprobar(stripslashes($_POST["introEmail"]), stripslashes($_POST["introPwd"]))) {
        $_SESSION['usuario'] = $usuario -> id;
        if (isset($_REQUEST['redirect'])) {
            header('Location: ' . base64_decode($_REQUEST['redirect']));
        } else {
            $msg[] = "Acceso correcto";
            $html -> asignar("msg", $msg);
            call_user_func('usuario');
        }
    } else {
        session_destroy();
        $html -> assign("msg_err", "<strong>Error: </strong> Compruebe su nombre de usuario y contraseña");
        $html -> plantilla("login.tpl");
        $html -> ver();
    }
}

function usuario_editar() {
    global $html, $usuario, $mod;
    $html -> asignar("val", $usuario);
    $html -> botones("editar.botones.tpl");
    if ($media = GetMediaFromModulo($mod, $usuario -> id)) {
        $html -> asignar("media", $media);
    }
    $html -> plantilla("editar.tpl");
    $html -> ver();
}

function usuario_guardar() {
    global $usuario, $mod, $html;

    $msg       = array();
    $idusu     = filter_input(INPUT_POST, 'idusuario');
    $password  = filter_input(INPUT_POST, 'password');
    $password1 = filter_input(INPUT_POST, 'newpassword');
    $password2 = filter_input(INPUT_POST, 'newpassword2');
    $nombre    = filter_input(INPUT_POST, 'nombre');
    $apellidos = filter_input(INPUT_POST, 'apellidos');

    if ($password) {
        $oldu = new Usuario($idusu);
        if (!$oldu->verifica_password($password)) {
            $msg[] = "La contraseña actual no es correcta";
        }
    } else {
        $msg[] = "Contraseña actual no especificada";
    }

    if (strlen($password1) < 3) {
        $msg[] = "La contraseña debe tener una longitud de al menos 3 caracteres";
    }

    if ($password1 != $password2) {
        $msg[] = "Las contraseñas no coinciden";
    }

    if (!$msg) {
        if ($_FILES) {
            $_POST['image'] = $_FILES; //añadimos a POST lo enviado por FILES
        }

        if ($usuario -> editar($_POST)) {
            $msg[] = "Datos actualizados correctamente";
            $html -> asignar("msg", $msg);
            call_user_func('usuario');
        }
    } else {
        $html -> asignar("msg", $msg);
        call_user_func('usuario_editar');
    }
}

function usuario_fb() {
    global $baseurl, $subop;
    $fb = new Facebook\Facebook([
        'app_id'                => FB_API_APP_ID,
        'app_secret'            => FB_API_APP_SECRET,
        'default_graph_version' => 'v2.12'
    ]);

    $helper = $fb -> getRedirectLoginHelper();
    //var_dump($helper);
    try {
        $accessToken = $helper -> getAccessToken();
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e -> getMessage();
        //exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e -> getMessage();
        //exit;
    }

    if (isset($accessToken)) {
        // Logged in!
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        $fb -> setDefaultAccessToken($_SESSION['facebook_access_token']);
        $response                          = $fb -> get('/me?locale=es_ES&fields=name,email,first_name,last_name');
        $userNode                          = $response -> getGraphUser();

        //var_dump($userNode);
        //var_dump($userNode -> getField('email'), $userNode['email']);
        //var_dump($_REQUEST);
        $u = new Usuario();
        $u -> confirmarRRSS($userNode -> getField('email'), $userNode -> getField('id'), $userNode -> getField('first_name'), $userNode -> getField('last_name'), "//graph.facebook.com/" . $userNode -> getField('id') . "/picture", 'fb');

        if (isset($subop)) {
            header('Location: ' . base64_decode($subop));
        } else {
            header("Location: $baseurl");
        }

        //header("Location: /usuarios/");
        // Now you can redirect to another page and use the
        // access token from $_SESSION['facebook_access_token']
    } else {
        if ($helper -> getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper -> getError() . "\n";
            echo "Error Code: " . $helper -> getErrorCode() . "\n";
            echo "Error Reason: " . $helper -> getErrorReason() . "\n";
            echo "Error Description: " . $helper -> getErrorDescription() . "\n";
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        exit;
    }
}

if (isset($_GET["op"])) {
    $op = $_GET["op"];
}

function usuario_google() {
    global $baseurl;

    $redirect_uri = $baseurl . "usuarios/google/";
    $gClient      = new Google_Client();
    $gClient -> setApplicationName(GOOGLE_API_APPNAME);
    $gClient -> setClientId(GOOGLE_API_OAUTH2_CLIENT_ID);
    $gClient -> setClientSecret(GOOGLE_API_OAUTH2_CLIENT_SECRET);
    $gClient -> setRedirectUri($redirect_uri);
    $gClient -> setScopes(array('https://www.googleapis.com/auth/analytics.readonly', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));

    if (isset($_REQUEST['code'])) {
        $gClient -> authenticate($_REQUEST['code']);
        $_SESSION['token'] = $gClient -> getAccessToken();
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }

    if (isset($_SESSION['token'])) {
        $gClient -> setAccessToken($_SESSION['token']);
    }

    if ($gClient -> getAccessToken()) {
        $googlePlus  = new Google_Service_Oauth2($gClient);
        $userProfile = $googlePlus -> userinfo -> get();
        //var_dump($userProfile);

        $u = new Usuario();
        $u -> confirmarRRSS($userProfile -> email, $userProfile -> id, $userProfile -> givenName, $userProfile -> familyName, $userProfile -> picture, "google");

        if (isset($subop)) {
            header('Location: ' . base64_decode($subop));
        } else {
            header("Location: $baseurl");
        }
    } else {
        $authUrl = $gClient -> createAuthUrl();
    }
}

if (isset($usuario -> verificado) && $usuario -> verificado != 0)
    $html -> assign("verificado", $usuario -> verificado);

if (isset($usuario -> dataverificacion))
    $html -> assign("dataverificacion", $usuario -> dataverificacion);

function usuario_alta() {
    $u = new Usuario();
    if ($u -> peticion($_POST["email"]))
        $html -> assign("msg", "Revise su email para continuar el proceso de alta");
    else
        $html -> assign("msg_err", "<strong>Error:</strong> Ya está registrado o ya ha hecho una petición de registro las últimas 24 horas (compruebe su correo)");
    unset($op);
}

function usuario_admin() {
    $permisoGeneral = getPermiso($usuario, $mod);
    var_dump($permisoGeneral);
    $usuarios       = new ControladorUsuarios();
    $listado        = $usuarios -> getUsuariosLDAP();
    $html -> asignar("tablaUsuarios", $listado);
    $html -> plantilla("admin.tpl");
    $html -> ver();
    //var_dump($listado);
}

function usuario_old() {

    // colaborador
    if ($usuario -> id > 0) {

        $html -> assign("ciudad", $ciudad);
        $html -> assign("intereses", $intereses);
        $html -> assign("distritos", $distritos);
        $html -> assign("txtdistritos", $txtdistritos);
        $html -> assign("externos", $externos);

        if ($_GET["go"] == "colaborador")
            if (isset($_POST["nombre"]))
                $usuario -> AltaColaborador($_POST);

        if ($usuario -> GetColaborador()) {
            if ($_GET["go"] == "colaborador") {

                $cambio = Array();
                if (!(isset($_POST["nombre"]))) {
                    if (isset($_POST["mailing"]))
                        $ma       = 1;
                    else
                        $ma       = 0;
                    if ($ma <> $usuario -> colaborador[mailing])
                        $cambio[] = "mailing=$ma";
                    if (isset($_POST["moviling"]))
                        $mo       = 1;
                    else
                        $mo       = 0;
                    if ($mo <> $usuario -> colaborador[moviling])
                        $cambio[] = "moviling=$mo";
                }

                if (count($cambio) > 0)
                    mysqli_query($cnx, "update colaboradores set " . implode(",", $cambio) . " where id=" . $usuario -> id);
                echo mysqli_error($cnx);

                mysqli_query($cnx, "delete from intereses where usuario=" . $usuario -> id);
                foreach ($intereses as $in) {
                    foreach ($in as $k => $v) {
                        if (isset($_POST[$k]))
                            mysqli_query($cnx, "insert into intereses(usuario,interes) values(" . $usuario -> id . ",'$k')");
                    }
                }

                $usuario -> GetColaborador();
            }
            $html -> assign("interesesusuario", $usuario -> intereses);
            $html -> assign("colaborador", $usuario -> colaborador);
        }
    }

    $html -> asignar("loginUrlfb", getURLFB());
    $html -> asignar("loginUrlGoogle", getURLGoogle());
    $html -> asignar("refURL", $_REQUEST['redirect']);
    $html -> asignar("u", $usuario);
    $html -> plantilla("inicio.tpl");
    $html -> ver();
}

if ($op == "alta3") {
    $n         = $_POST['u'];
    $pa        = $_POST['pa'];
    $pb        = $_POST['pb'];
    $nombre    = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];

    unset($msg);
    if (strlen($nombre) > 250)
        $msg = "El nombre es demasiado largo";
    if (strlen($nombre) < 3)
        $msg = "El nombre es demasiado corto";
    if ((strlen($pa) < 3) || (strlen($pa) > 12))
        $msg = "La contraseña debe contener entre 3 y 12 carácteres";
    if ($pa != $pb)
        $msg = "Las contraseñas no son iguales";

    if (isset($msg)) {
        $html -> assign("msg", $msg);
        $op        = "alta2";
        $_GET[pwd] = $_POST[pwd];
        mostrartpl("header.tpl");
    } else {
        $u = new Usuario();
        $u -> confirmar($_POST[pwd], $nombre, $apellidos, $pa);
        $html -> assign("msg", "Ya estás registrado@");
        mostrartpl("header.tpl");
        echo "Ya estás registrad@ ;) <br><a class=button href='/?mod=usuario'>Acceder</a>";
    }
}

if ($op == "alta2") {
    $u     = new Usuario();
    if ($email = $u -> preconfirmar($_GET[pwd])) {
        if (isset($msg))
            $html -> assign("msg", $msg);
        $html -> assign("email", $email);
        $html -> assign("nick", $_POST[u]);
        if ($pa == $pb)
            $html -> assign("pab", $pa);
        $html -> assign("pwd", $_GET[pwd]);

        $html -> plantilla("registro.tpl");
        $html -> ver();
    } else
        echo "Validacion incorrecta";
}

if ($op == "recordar") {

    #  $u=new Usuario();
    #  $u=GetUsuarioByEmail
    #  $u->email=$_POST[email];
    #  $u->recordar();3
    #  $html->assign("msg","Compruebe su correo electrónico");
    #  $html->display("inicio.tpl");

    if ($subop == "go") {
        $x = explode("-", $_GET[md]);
        if (count($x) == 2) {
            $u = new Usuario((int) $x[0]);
            if ($u -> md($x[1])) {
                $html -> assign("md", $_GET[md]);
                if ($_POST[pwda]) {
                    unset($msg);
                    if ((strlen($_POST[pwda]) < 3) || (strlen($_POST[pwda]) > 10))
                        $msg = "La contraseña debe contener entre 3 y 10 carácteres";
                    if ($_POST[pwda] != $_POST[pwdb])
                        $msg = "Las contraseñas no iguales";
                    if ($msg) {
                        $html -> assign("msg", $msg);
                        $html -> plantilla("reset.password.tpl");
                    } else {
                        $u -> setpwd($_POST[pwda]);
                        $html -> assign("msg", "Contraseña reseteada");
                        $html -> plantilla("inicio.tpl");
                    }
                } else {
                    $html -> plantilla("reset.password.tpl");
                }
            } else
                echo "Petición expirada, vuelva a intentarlo.";
        }
    }
    if (!($subop)) {

        $u = GetUsuarioByEmail($_POST['introEmail']);

        if ($u) {
            $u -> recordar();
            $html -> assign("msg", "Compruebe su correo electrónico");
        } else
            $html -> assign("msg", "No está registrado");
        $html -> plantilla("inicio.tpl");
        $html -> ver();
    }
}

if ($op == "modificar") {
    //var_dump($usuario);
    $_POST['usuarioid']      = $usuario -> id;
    $_POST['datosCompletos'] = 1;
    //var_dump($_POST);
    if ($usuario -> modificar($_POST)) {
        if ($_POST['refURL'] != "")
            header("Location: " . base64_decode($_POST['refURL']));
        else
            header("Location: /usuario/");
    }
}

function getURLFB() {
    global $baseurl;

    $fb = new Facebook\Facebook(['app_id' => FB_API_APP_ID, 'app_secret' => FB_API_APP_SECRET, 'default_graph_version' => 'v2.12',]);

    $helper      = $fb -> getRedirectLoginHelper();
    $permissions = ['email', 'public_profile '];
    // optional
    $loginUrl    = $helper -> getLoginUrl($baseurl . 'usuario/fb/' . $_REQUEST['redirect'] . '/', $permissions);
    $loginUrl    = $helper -> getLoginUrl($baseurl . 'usuario/fb/', $permissions);

    return $loginUrl;
}

function getURLGoogle() {
    global $baseurl;


    $gClient = new Google_Client();
    $gClient -> setApplicationName(GOOGLE_API_APPNAME);
    $gClient -> setClientId(GOOGLE_API_OAUTH2_CLIENT_ID);
    $gClient -> setClientSecret(GOOGLE_API_OAUTH2_CLIENT_SECRET);
    $gClient -> setRedirectUri($baseurl . "usuario/google/");
    $gClient -> setScopes(array('https://www.googleapis.com/auth/analytics.readonly', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
    return $gClient -> createAuthUrl();
}
