<?php

/*

  CREATE TABLE permisos (
  usuario int(11),
  modulo char(50),
  elemento int(11),
  nivel int(11),
  primary key(usuario,modulo,elemento)
  );

  usuario: id del usuario
  modulo: tipo de permisos (proveedor, marca, agencia, etc.)
  elemento: id del proveedor, marca, agencia, etc.
  nivel: nivel de los permisos, de momento siempre 100

 */

function getGrupos($usuario) {
    global $db;

    if (is_object($usuario)) {
        $db -> where('usuario', $usuario -> id);
    } else {
        $db -> where('usuario', $usuario);
    }

    $db -> where('activo', 1);
    $db -> orderBy('grupo', 'DESC');
    $res = $db -> get('seguridad_usuarios_en_grupos');

    $sal = Array();
    foreach ($res as $row) {
        $sal[] = $row['grupo'];
    }
    return $sal;
}

function getPadre($grupo) {
    global $db;
    $db -> where('id', $grupo);
    $res = $db -> get('seguridad_grupos', 'padre');

    $sal = Array();
    if ($db -> count > 0) {
        $row = $res[0];
        if (is_null($row['padre']))
            return null;
        else
            return (int) $row['padre'];
    } else
        return null;
}

function getPermisoGrupo($opciones = array()) {
    global $db;
    $grupo         = (array_key_exists('grupo', $opciones) ? $opciones['grupo'] : "");
    $modulo        = (array_key_exists('modulo', $opciones) ? $opciones['modulo'] : null);
    $elemento      = (array_key_exists('elemento', $opciones) ? $opciones['elemento'] : 0);
    $identificador = (array_key_exists('identificador', $opciones) ? $opciones['identificador'] : false);

    $campo = ($identificador ? 'id' : 'nivel');


    $db -> where('grupo', $grupo);

    if (is_null($modulo) || $modulo == '') {
        $db -> where('modulo', NULL, 'IS');
    } else {
        $db -> where('modulo', $modulo);
    }

    if (is_null($elemento) || $elemento == '') {
        $db -> where('elemento', NULL, 'IS');
    } else {
        $db -> where('elemento', $elemento);
    }

    $res = $db -> get('seguridad', null, array($campo));

    if ($db -> count > 0) {
        $row = $res[0];
        return (int) $row[$campo];
    } else {
        return 0;
    }
}

function getPermisoDefecto($opciones = array()) {
    global $db;
    $modulo        = (array_key_exists('modulo', $opciones) ? $opciones['modulo'] : null);
    $elemento      = (array_key_exists('elemento', $opciones) ? $opciones['elemento'] : 0);
    $identificador = (array_key_exists('identificador', $opciones) ? $opciones['identificador'] : false);

    $campo = ($identificador ? 'id' : 'nivel');

    $db -> where('grupo', NULL, 'IS');

    $sql = "select $campo from seguridad WHERE grupo IS NULL ";

    if (is_null($modulo) || $modulo == '') {
        $db -> where('modulo', NULL, 'IS');
    } else {
        $db -> where('modulo', $modulo);
    }

    if (is_null($elemento) || $elemento == '') {
        $db -> where('elemento', NULL, 'IS');
    } else {
        $db -> where('elemento', $elemento);
    }

    $db -> get('seguridad', $campo);
    //var_dump($sql);

    if ($db -> count > 0) {
        $row = $res[0];
        return (int) $row[$campo];
    } else {
        return 0;
    }
}

function getPermiso($usuario, $modulo = null, $elemento = 0, $identificador = false) {
    global $db;

    //Primero comprobamos si existen los requisitos de base de datos
    //suficientes como para hacer las comprobaciones
    $tablas = array('seguridad', 'seguridad_grupos', 'seguridad_usuarios', 'seguridad_usuarios_en_grupos');
    foreach ($tablas as $tabla) {
        if (!$db -> tableExists($tabla)) {
            echo "ERROR: No existe la tabla " . DB_PREFIX . $tabla;
            echo "<br>Check db_schema/seguridad.sql";
            exit;
        }
    }    

    //La variable INDENTIFICADOR nos permite conocer la ID del permiso en la base de datos que afecta

    $grupos  = getGrupos($usuario);
    $valores = Array();

    // Obtenemos permisos por defecto de un modulo de usuarios que no tienen asignado grupo.
    // Pero que están identificados
    if ($usuario -> id > 0 && isset($modulo)) {
        $valores[0] = getPermisoDefecto(array('modulo' => $modulo, 'identificador' => false));
        $ids[0]     = getPermisoDefecto(array('modulo' => $modulo, 'identificador' => true));
    }

    foreach ($grupos as $g) {
        $valores[$g] = getPrimeraOcurrencia($g, $modulo, $elemento);
        if ($identificador)
            $ids[$g]     = getPrimeraOcurrencia($g, $modulo, $elemento, true);
    }

    //var_dump($grupos);
    //var_dump($valores);

    if ($valores) {
        if ($identificador) {
            //var_dump($valores);
            $res = array();
            foreach (array_keys($valores, max($valores)) as $elID) {
                $res[] = $ids[$elID];
            }
            return implode(array_unique($res), ", ");
        } else {
            //var_dump($valores);
            return max($valores);
        }
    } else {
        return 0;
    }
}

function getPermisosFull() {
    
}

//ALIAS DE FUNCION
function getPermisos($usuario, $modulo = null, $elemento = 0, $identificador = false) {
    return getPermiso($usuario, $modulo, $elemento);
}

function getPrimeraOcurrencia($g, $modulo = null, $elemento = 0, $identificador = false) {
    $g = (int) $g;

    $valor = getPermisoGrupo(array('grupo' => $g, 'modulo' => $modulo, 'elemento' => $elemento, 'identificador' => $identificador));
    if ($valor == 0) {
        $valor = getPermisoGrupo(array('grupo' => $g, 'modulo' => $modulo, 'identificador' => $identificador));
        if ($valor == 0) {
            $valor = getPermisoGrupo(array('grupo' => $g, 'identificador' => $identificador));
            if ($valor == 0) {
                $padre = getPadre($g);
                if ($padre)
                    return getPrimeraOcurrencia($padre, $modulo, $elemento, $identificador);
                else
                    return 0;
            } else {
                return $valor;
            }
        } else {
            return $valor;
        }
    } else {
        return $valor;
    }
}

function p($usuario, $modulo = null, $elemento = 0, $nivel, $mensaje = "NO TIENE PERMISOS") {
    global $debug;
    if (getPermisos($usuario, $modulo, $elemento) < $nivel) {
        echo "<div class='alert alert-danger'><strong>ERROR:</strong> $mensaje</div>";
        echo "<button type='button' onclick='javascript:window.history.back();' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-arrow-left'></span> Volver</button>";
        exit;
    }
}

function ListUsuariosPermisos($modulo, $elemento) {
    global $db;
    $db -> where('elemento', $elemento);
    $db -> where('modulo', $modulo);
    $res = $db -> get('permisos');

    $sal = Array();
    foreach ($res as $row) {
        $u          = new Usuarios(false, (int) $row['usuario']);
        $u -> nivel = (int) $row['nivel'];
        $sal[]      = $u;
    }
    return $sal;
}

function SetPermiso($usuario, $modulo, $nivel, $elemento = 0) {
    global $cnx;
    if ($nivel == 0) {

        $p = GetPermiso($usuario, $modulo, $elemento);
        if ($p = 100) {
            $sql = "select count(*) as n from permisos  WHERE modulo='$modulo' and elemento=$elemento ";
            $n   = mysqli_fetch_array(mysqli_query($cnx, $sql));
            if ($n[n] == 1)
                return false;
        }

        $sql = "DELETE FROM permisos WHERE modulo='$modulo' and elemento=$elemento and usuario=" . $usuario -> id;
        //echo $sql;
        mysqli_query($cnx, $sql);
        return true;
    }

    $sql = "insert into permisos (usuario,modulo,elemento,nivel) values
     (" . $usuario -> id . ",'$modulo',$elemento,$nivel) ";

    if ($res = mysqli_query($cnx, $sql))
        return true;
    else
        return false;
}

function SetEmail($email, $modulo, $nivel, $elemento = 0) {
    return false;
    global $cnx;
    if ($nivel == 0) {
        $sql = "DELETE FROM permisos WHERE modulo='$modulo' and elemento=$elemento and usuario=" . $usuario -> id;
        mysqlo_query($cnx, $sql);
        return true;
    }

    $sql = "insert into permisos (usuario,modulo,elemento,nivel) values
     (" . $usuario -> id . ",'$modulo',$elemento,$nivel) ";

    if ($res = mysqli_query($cnx, $sql))
        return true;
    else
        return false;
}

function PermisosInvitar($email, $modulo, $elemento, $nivel) {
    global $titulopagina, $baseurl, $siteadmin, $cnx;
    $sql = "select id from usuarios where email=\"" . addslashes($email) . "\" ";
    $res = mysqli_query($sql);
    if ($row = mysqli_fetch_array($res)) {
        $sql = "insert into permisos (usuario,modulo,elemento,nivel) values
        ($row[id],'$modulo',$elemento,$nivel) ";
        mysqli_query($cnx, $sql);
    } else {
        mysqli_query($cnx, "insert into permisos_pendientes (email,modulo,elemento,nivel)
                 values (\"" . addslashes($email) . "\",'$modulo',$elemento,$nivel) ");
        $pwd          = rand(10000000, 99999999);
        mysqli_query($cnx, "insert into usuarios_peticiones(id,email,fecha,pwd)
                 values ( 0 , \"" . addslashes($email) . "\" , now() , $pwd )
    ");
        $id           = mysqli_insert_id($cnx);
        $c            = new Correo();
        $c -> to      = $email;
        $c -> from    = $siteadmin;
        $c -> fromtxt = $titulopagina;
        $c -> titulo  = "Proceso de Alta en $titulopagina";
        $txt          = "
    Se ha creado un acceso para usted en <strong>$titulopagina</strong>
    <br>
    Para completar su alta debe visitar el siguiente enlace:
          <br>
          <a href='$baseurl/usuarios/alta2/?pwd=$pwd-$id'>
             $baseurl/usuarios/alta2/?pwd=$pwd-$id
          </a>
    ";
        $c -> enviar($txt);
        return true;
    }
}

class GrupoSeguridad {

    function __construct($id, $hijo = NULL) {
        global $cnx;

        if (is_array($id)) {
            //es un array, lo tratamos como nuevo y una inserción.
            //TODO: insertar expediente
        }

        $cols = array('id', 'nombre', 'padre');
        $db -> where('id', null, $id);
        $res  = $db -> get('seguridad_grupos', $cols);


        if ($db -> count > 0) {
            $row            = $res[0];
            $this -> id     = $row['id'];
            $this -> nombre = $row['nombre'];
            $this -> hijo   = $hijo;
            $this -> padre  = (!is_null($row['padre'])) ? new GrupoSeguridad($row['padre'], $this -> id) : null;
        }
    }

}
