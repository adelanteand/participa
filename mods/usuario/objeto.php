<?php

importclass("correo");
importclass("permisos");

// TODO: Eliminar métodos no usados y obsoletos. Limpiar código 20180811

class Usuario extends Entidad {

    var $id = 0;
    
    private $datos = array(
            'tabla'    => "seguridad_usuarios",
            'manuales' => array(
                'user',
                'pwd',
                'email',
                'tipo',
                'nombre',
                'apellidos',
                'metodo',
                'tlf1',
                'tlf2',
                'cp',
                'localidad'
            ),
            'pwd'      => array('pwd')
        );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);        
    }

    function editar($id) {
        return parent::edit($id, $this->datos);
    }
    
    function eliminar() {
        return parent::remove($this->datos);
    }    

    function verifica_password($password){
        return password_verify($password, $this -> pwd);
    }
    
    
    function GetFechaAlta() {
        global $cnx;
        $sql = "select fecha from seguridad_usuarios where id = " . $this -> id;
        $res = mysqli_query($cnx, $sql);
        if ($row = mysqli_fetch_array($res))
            return $row['fecha'];
        else
            return false;
    }

    function peticion($email) {

        global $baseurl, $ciudad, $siteadmin, $titulopagina, $cnx;
        mysqli_query($cnx, "delete from usuarios_peticiones where fecha < (now() - interval 1 day) ");
        $sql = "select count(*) as n from usuarios_peticiones where 
        email=\"" . addslashes($email) . "\"
    ";
        $res = mysqli_query($cnx, $sql);
        $row = mysqli_fetch_array($res);
        if ($row[n] > 0)
            return false;

        $sql = "select count(*) as n from seguridad_usuarios where 
        email=\"" . addslashes($email) . "\"
    ";
        $res = mysqli_query($cnx, $sql);
        $row = mysqli_fetch_array($res);
        if ($row[n] > 0)
            return false;

        $pwd          = rand(10000000, 99999999);
        mysqli_query($cnx, "insert into usuarios_peticiones(id,email,fecha,pwd)
      values ( NULL , \"" . addslashes($email) . "\" , now() , $pwd )
    ");
        $id           = mysqli_insert_id($cnx);
        /*
          mail($email,
          "Alta en $titulopagina"  ,"Para completar su alta debe visitar el siguiente enlace:\n".$baseurl."/?mod=usuarios&op=alta2&pwd=$pwd-$id\n\n",
          "From: $siteadmin\r\nReply-To: $siteadmin");
         */
        $c            = new Correo();
        $c -> to      = $email;
        $c -> from    = $siteadmin;
        $c -> fromtxt = $titulopagina;
        $c -> titulo  = "Confirmación de Alta";
        $txt          = "Para completar su alta debe visitar el siguiente enlace:
    <br>
    <a href='$baseurl/usuarios/alta2/?pwd=$pwd-$id'>
       $baseurl/usuarios/alta2/?pwd=$pwd-$id
    </a>
    ";
        $c -> enviar($txt);
        return true;
    }

    function preconfirmar($pwd) {
        global $cnx;
        $p    = explode("-", $pwd);
        $p[0] = (int) $p[0];
        $p[1] = (int) $p[1];
        $sql  = "select email from usuarios_peticiones where 
    id=$p[1] and pwd=$p[0]
    ";
        $res  = mysqli_query($cnx, $sql);
        echo mysqli_error($cnx);
        if ($row  = mysqli_fetch_array($res))
            return $row[email];
        else
            return false;
    }

    function confirmar($pwd, $nombre = "", $apellidos = "", $contra) {
        global $cnx;
        $p    = explode("-", $pwd);
        $p[0] = (int) $p[0];
        $p[1] = (int) $p[1];
        $sql  = "select * from usuarios_peticiones where 
    id=$p[1] and pwd=$p[0]
    ";
        $res  = mysqli_query($cnx, $sql);
        echo mysqli_error($cnx);
        if ($row  = mysqli_fetch_array($res)) {
            $user = $row['email'];
            $sql  = "INSERT INTO seguridad_usuarios (id,tipo,user,nombre,apellidos,email,pwd,fecha)
        values(NULL,'Normal',\"" . addslashes($row['email']) . "\",\"" . addslashes($nombre) . "\",\"" . addslashes($apellidos) . "\",\"" . addslashes($row['email']) . "\",password(\"" . addslashes($contra) . "\"),now())
      ";
            mysqli_query($cnx, $sql);
            $idu  = mysqli_insert_id($cnx);
            if ($idu == 1) {
                SetPermiso(new Usuarios(false, $idu), "admin", 100);
            }
            $this -> comprobar($row["email"], $contra);
            return true;
        } else
            return false;
    }

    function confirmarRRSS($email, $user, $nombre = "", $apellidos = "", $avatar = "", $tipo = "fb") {
        global $cnx;
        $sql = "INSERT INTO seguridad_usuarios (tipo,user,nombre,apellidos,email,pwd,fecha,metodo,avatar)
        values('Normal',\"" . addslashes($user) . "\",\"" . addslashes($nombre) . "\",\"" . addslashes($apellidos) . "\",\"" . addslashes($email) . "\",NULL,now(),\"" . addslashes($tipo) . "\",\"" . addslashes($avatar) . "\")";
        mysqli_query($cnx, $sql);
        //echo $sql;
        //exit;
        $idu = mysqli_insert_id($cnx);
        if ($idu == 1) {
            SetPermiso(new Usuarios(false, $idu), "admin", 100);
        }

        $this -> entrarRRSS($email);
        return true;
    }

    function confirmarLDAP($usuario, $email, $nombre, $apellidos, $contra) {
        global $cnx;
        $sql = "
        INSERT INTO 
            seguridad_usuarios (id,user,nombre,apellidos,email,pwd,fecha,tipo) 
        VALUES
            (NULL,\"" . addslashes($usuario) . "\",\"" . addslashes($nombre) . "\",\"" . addslashes($apellidos) . "\",\"" . addslashes($email) . "\",password(\"" . addslashes($contra) . "\"),now(),'LDAP')
    ";
        mysqli_query($cnx, $sql);

        $idu = mysqli_insert_id($cnx);

        if ($idu == 1) {
            SetPermiso(new Usuarios(false, $idu), "admin", 100);
        }

        $this -> comprobar($usuario, $contra);
        return true;
    }

    function salir() {
        global $baseurl;

        session_start();
        session_destroy();


        if (isset($_GET['redirect'])) {
            header('Location: ' . base64_decode($_GET['redirect']));
        } else {
            header("Location: $baseurl");
        }
    }

    function comprobar($user, $pwd, $permanente = false) {

        global $baseurl, $db, $rand;

        $cols = array('id', 'pwd', 'user', 'email', 'tipo', 'karma', 'avatar', 'tlf1', 'tlf2', 'cp', 'localidad', 'circulo', 'datosCompletos');
        $db -> where('user', addslashes($user));
        $res  = $db -> getOne('seguridad_usuarios', null, $cols);

        if ($db -> count == 0) {
            //no existe en la base de datos ese nombre de usuario
            //en ese caso, comprobamos iniciar sesión directamente por LDAP
            if (LDAP_SERVER) {
                $this -> comprobarLDAP();
            }
        }

        if (password_verify($pwd, $res['pwd'])) {
            $valido = 1;
        } else {
            $valido = 0;
        }

        //var_dump($rand);

        if ($valido) {
            $this -> id        = $res['id'];
            $this -> user      = $res['user'];
            $this -> fullName  = $res['nombre'] . " " . $res['apellidos'];
            $this -> nombre    = $res['nombre'];
            $this -> apellidos = $res['apellidos'];
            $this -> email     = $res['email'];
            $this -> avatar    = $res['avatar'];
            $this -> karma     = $res['karma'];
            $this -> tlf1      = $res['tlf1'];
            $this -> tlf2      = $res['tlf2'];
            $this -> cp        = $res['cp'];
            $this -> localidad = $res['localidad'];
            //$this -> ComprobarVerificacion(3);
            $this -> acceso('Válido');
        } else {
            $this -> acceso('Fallido');
        }

        return $valido;
    }

    function comprobarLDAP() {
        $ldap = ldap_connect($ldap_server);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        $dn   = $ldap_idatribute . "=" . $user . "," . $ldap_basedn;

        if ($bind = ldap_bind($ldap, $dn, $pwd)) {
            //identificados en LDAP sin registor en la base de datos
            //crear el registro
            $filter    = "(uid=$user)";
            $result    = ldap_search($ldap, $dn, $filter);
            $info      = ldap_get_entries($ldap, $result);
            $nombre    = $info[0][givenname][0];
            $apellidos = $info[0][sn][0];
            $email     = $info[0][mail][0];

            //vemos si está en grupos autorizados
            $bind               = ldap_bind($ldap, $ldap_adminuser, $ldap_adminpwd);
            $filter             = "(uid=autorizados_intranet)";
            $result             = ldap_search($ldap, $ldap_basedn, $filter);
            $info               = ldap_get_entries($ldap, $result);
            $grupos_autorizados = $info[0][zimbramailforwardingaddress];
            //var_dump($grupos_autorizados);
            $autoriza           = false;
            for ($i = 0; $i <= sizeof($grupos_autorizados) && $autoriza == false; $i++) {
                if ($email == $grupos_autorizados[$i])
                    $autoriza = true;
                else {
                    $subfilter         = "(mail=" . $grupos_autorizados[$i] . ")";
                    $result            = ldap_search($ldap, $ldap_basedn, $subfilter);
                    $info              = ldap_get_entries($ldap, $result);
                    $mails_autorizados = $info[0][zimbramailforwardingaddress];
                    for ($j = 0; $j <= sizeof($mails_autorizados) && $autoriza == false; $j++) {
                        if ($email == $mails_autorizados[$j])
                            $autoriza = true;
                    }
                }
            }

            if ($autoriza) {//está en LDAP y está autorizado
                $user_id = $this -> confirmarLDAP($user, $email, $nombre, $apellidos, $pwd);
                return false;
            } else//no está autorizado en LDAP
                return false;
        } else {
            //no existe el usuario en LDAP. viento fresco
            //echo "No existe el usuario";
            return false;
        }
    }

    function entrarRRSS($email, $permanente = false) {

        global $baseurl, $cnx;

        $sql = "select id,pwd,user,email, avatar, karma from seguridad_usuarios where 
       email = \"" . addslashes($email) . "\"  ";

        $res = mysqli_query($cnx, $sql);
        echo mysqli_error($cnx);

        //comprobamos si existe
        if (!($row = mysqli_fetch_array($res))) {
            return false;
        }

        if ($permanente)
            $t = time() + 30 * 24 * 60 * 60;
        else
            $t = 0;


        setcookie("usuario", $row["id"] . "-" . md5($row["pwd"]) . "-" . $permanente, $t, "/", $_SERVER["HTTP_HOST"]);

        $this -> id     = $row['id'];
        $this -> user   = $row['user'];
        $this -> email  = $row['email'];
        $this -> avatar = $row['avatar'];
        $this -> karma  = $row['karma'];
        $this -> ComprobarVerificacion(3);
        $this -> acceso();
    }

    function acceso($tipo = 'Valido') {
        global $db;
        $data = Array(
            "id_user" => $this -> id,
            "tipo"    => $tipo
        );
        $id   = $db -> insert('seguridad_usuarios_acceso', $data);
        //var_dump($db->getLastQuery());
        if ($id) {
            return true;
        } else {
            return false;
        }
    }

    function recordar() {
        global $bd_password, $titulopagina, $baseurl, $siteadmin, $cnx;
        $md           = $bd_password . $this -> id . $this -> user . $this -> email . date("j-m-y");
        $md           = md5($md);
        $url          = $baseurl . "/usuarios/recordar/go/?md=" . $this -> id . "-$md";
        /* mail($this->email,
          "Recordatorio de contraseña para $titulopagina"  ,"Para cambiar su contraseña debe visitar el siguiente enlace:\n".$baseurl.
          "/usuarios/recordar/go/?md=".$this->id."-$md\n\n
          "); */
        #Avisador($this,"Recordatorio de contraseña para $titulopagina","     Para cambiar su contraseña debe visitar el siguiente enlace:\n\n<br>\n\n<a href='$url'>\n$url\n</a>");
        $c            = new Correo();
        $c -> to      = $this -> email;
        $c -> from    = $siteadmin;
        $c -> fromtxt = $titulopagina;
        $c -> titulo  = "Recordatorio de contraseña para $titulopagina";
        $txt          = "Para cambiar su contraseña debe visitar el siguiente enlace:
    <br>
    <a href='$url'>
       $url
    </a>
    ";
        $c -> enviar($txt);
        return true;
    }

    function md($mdin) {
        global $bd_password, $titulopagin, $baseurl, $cnx;
        $md = $bd_password . $this -> id . $this -> user . $this -> email . date("j-m-y");
        $md = md5($md);
        return ($md == $mdin);
    }

    function setpwd($pwd) {
        global $db;
        $data = Array(
            'pwd' => password_hash($pwd, PASSWORD_DEFAULT)
        );
        $db -> where('id', $this -> id);
        $db -> update('seguridad_usuarios', $data);
    }

    function setuser($user) {
        global $db;
        $data         = Array(
            'user' => addslashes($user)
        );
        $db -> where('id', $this -> id);
        $db -> update('seguridad_usuarios', $data);
        $this -> user = $user;
    }

    function setfoto($fichero) {
        $ant = GetMediaFromModulo("usuario", $this -> id);
        $m   = CrearMediaFromImagen($fichero, "usuario", $this -> id);
        if ($m && $ant) {
            $ant -> delete();
        }
    }

    /*
      $verificaciones=Array(
      "adjunto" => Array( "titulo" => "Fichero/s adjuntos" , "tipo"=>"adjunto"),
      "email" => Array( "titulo" => "Envio por email" , "tipo"=>"email"),
      "whatsapp" => Array( "titulo" => "Envio por whatsapp" , "tipo"=>"whatsapp"),
      "presencial" => Array( "titulo" => "Envio por whatsapp" , "tipo"=>"presencial")
      );

     */

    function Verificar() {
        global $cnx;
        $sql = "select * from verificaciones where usuario=" . $this -> id;
        $res = mysqli_query($cnx, $sql);

        if ($row = mysqli_fetch_array($res)) {
            if ($row['administrador'] != $this -> id)
                $row['administrador'] = new Usuarios(false, $row[administrador]);
            $row[data]            = unserialize($row['data']);
            return $row;
        }

        return false;
    }

    function InicioVerificacion($tipo, $documento, $data = false) {
        global $cnx;
        mysqli_query($cnx, "insert into verificaciones (usuario,tipo,documento,solicitada,data)
    values (" . $this -> id . ",'$tipo',\"" . addslashes($documento) . "\",now(),\"" . addslashes(serialize($data)) . "\" ) ");

        echo mysqli_error($cnx);
    }

    function __toString() {
        return $this -> fullName;
    }

    /*
      drop table verificaciones;
      create table verificaciones (
      usuario int(11),
      tipo char(20),
      documento char(50),
      solicitada datetime,
      aceptada datetime,
      administrador int(11),
      verificado int(11) default 0,
      data text,
      primary key(usuario)
      );

     */
}

class Usuarios_Controlador {
    
    public $orden = 'id';
    public $ordenTipo = 'ASC';
    
    function getUsuarios() {
        global $db;

        $cols = array('id');
        $db -> orderBy($this->orden,$this->ordenTipo);
        $res  = $db -> get('seguridad_usuarios', null, $cols);        
        $out  = Array();
        foreach ($res as $row) {
            $p     = new Usuario($row['id']);
            $out[] = $p;
        }
        
        return $out;
        
    }


    function getUsuariosLDAP($filtro = "*") {
        global $ldap_server, $ldap_idatribute, $ldap_basedn, $ldap_adminuser, $ldap_adminpwd, $cnx;

        $ldap = ldap_connect($ldap_server);
        if ($ldap === FALSE) {
            return false; //ERROR
        }
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

        if (TRUE === ldap_bind($ldap, $ldap_adminuser, $ldap_adminpwd)) {
            $ldap_base_dn  = $ldap_basedn;
            $search_filter = '(&(objectClass=inetOrgPerson)(uid=' . $filtro . '))';
            $attributes    = array();
            $attributes[]  = 'uid';
            $attributes[]  = 'cn';
            $attributes[]  = 'sn';
            $attributes[]  = 'givenName';
            $attributes[]  = 'displayName';
            $attributes[]  = 'mail';
            $attributes[]  = 'zimbraAccountStatus';
            $attributes[]  = 'zimbraCreateTimestamp';
            $attributes[]  = 'zimbraLastLogonTimestamp';


            $result  = ldap_search($ldap, $ldap_base_dn, $search_filter, $attributes);
            $ad_user = [];
            if (FALSE !== $result) {
                $entries = ldap_get_entries($ldap, $result);
                for ($x = 0; $x < $entries['count']; $x++) {
                    //Limpiamos el array de entradas LDAP
                    foreach ($attributes as $at) {
                        if (!empty($entries[$x][strtolower($at)])) {
                            if ($entries[$x][strtolower($at)]['count'] == 1) {
                                $ad_user[$x][strtolower($at)] = $entries[$x][strtolower($at)][0];
                            } else {
                                $ad_user[$x][strtolower($at)] = [];
                                for ($y = 0; $y < $entries[$x][strtolower($at)]['count']; $y++) {
                                    array_push($ad_user[$x][strtolower($at)], $entries[$x][strtolower($at)][$y]);
                                }
                            }
                        }
                    }
                }
            }
            ldap_unbind($ldap);
            return $ad_user;
        }

        return false;
    }

}

function GetUsuarioByEmail($email) {
    global $cnx;
    $sql = "select id from seguridad_usuarios where email=\"" . addslashes($email) . "\" ";
    //echo $sql;
    $res = mysqli_query($cnx, $sql);
    if ($row = mysqli_fetch_array($res)) {
        return new Usuarios(false, $row[id]);
    } else
        return false;
}