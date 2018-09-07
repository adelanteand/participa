<?php

function callFuncionParametros($miArray) {

    if ($miArray && is_array($miArray)) {
        if (function_exists(implode("_", $miArray))) {
            return implode("_", $miArray);
        } else {
            $eliminamos = array_pop($miArray);
            //echo "no existe la function ".implode("_", $miArray)."<br>";
            return callFuncionParametros($miArray);
        }
    } else {
        return 0;
    }
}

function fechaTOhace_old($t) {
    $t    = time() - $t;
    $hace = "$t segundos";
    if ($t > 59) {
        $t    = (int) ($t / 60);
        $hace = "$t minutos";
        if ($t > 59) {
            if ($t > 59) {
                $t    = (int) ($t / 60);
                $hace = "$t horas";
                if ($t > 23) {
                    $t    = (int) ($t / 24);
                    $hace = "$t días";
                    $d    = $t;
                    if ($t > 7) {
                        $t    = (int) ($t / 7);
                        $hace = "$t semanas";
                        if ($t > 5) {
                            $t    = (int) ($d / 30);
                            $hace = "$t meses";
                        }
                    }
                }
            }
        }
    }
    return $hace;
}

function fechaTOhace($datetime, $full = false) {
    $now  = new DateTime;
    $ago  = new DateTime($datetime);
    $diff = $now -> diff($ago);

    $diff -> w = floor($diff -> d / 7);
    $diff -> d -= $diff -> w * 7;

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'día',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );
    foreach ($string as $k => &$v) {
        if ($diff -> $k) {
            $v = $diff -> $k . ' ' . $v . ($diff -> $k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . '' : 'hace un momento';
}

#function FechaTXT($t)
#{
#  $s=Array("Dom","Lun","Mar","Mie","Jue","Vie","Sab");
#  $w=(int)Date("w",$t);
#  $w=$s[$w];
#  return "$w.".Date(" d/m/Y H:i",$t);
#}
#

function sololetras($txt) {
    $a = strtolower($txt);
    $b = "";
    $i = 0;
    while ($i < strlen($a)) {
        $c = $a[$i];
        if ((ord($c) >= ord("a")) && (ord($c) <= ord("z")))
            $b .= $c;
        $i++;
    }
    return $b;
}

function importclass($clase, $ruta = NULL) {
    /**
     * Esta función carga una clase definida en 
     * el fichero mods/??/objeto.php.
     * Es capaz de cargar de la aplicacion base (acbase)
     * o cargarlo de una aplicacion especifica conectada
     * y definida en config.php con la constante BASEPP 
     */
    global $home;    
    $base = ($ruta) ? $ruta : $home;    
    $f    = $base . "/clases/" . $clase . ".php";
    if (file_exists($f)) {
        require_once ($f);
    } elseif (file_exists($base . "/mods/$clase/objeto.php")) {
        require_once ($base . "/mods/$clase/objeto.php");
    }
}

function sololetrasynumeros($txt) {
    $a = strtolower($txt);
    $b = "";
    $i = 0;
    while ($i < strlen($a)) {
        $c = $a[$i];
        if ((ord($c) >= ord("a")) && (ord($c) <= ord("z")))
            $b .= $c;
        if ((ord($c) >= ord("0")) && (ord($c) <= ord("9")))
            $b .= $c;
        $i++;
    }
    return $b;
}

function mostrartpl($tpl, $retornar = false, $dir = false) {

    global $mod, $html, $baseMod;

    if (!$dir) {
        $html -> template_dir = $baseMod . 'tpl/';
        $html -> compile_dir  = CONF_HOME . 'smarty/templates_c/default/';
        $html -> config_dir   = CONF_HOME . 'smarty/configs/default/';
        $html -> cache_dir    = CONF_HOME . 'smarty/cache/default/';
    } else {
        $html -> template_dir = $baseMod . 'mods/' . $dir . '/tpl/';
        $html -> compile_dir  = CONF_HOME . 'smarty/templates_c/' . $dir . '/';
        $html -> config_dir   = CONF_HOME . 'smarty/configs/' . $dir . '/';
        $html -> cache_dir    = CONF_HOME . 'smarty/cache/' . $dir . '/';
    }

    if ($retornar) {
        $txt = $html -> fetch($tpl);
    } else {
        $html -> display($tpl);
    }

    $html -> template_dir = $baseMod . 'mods/' . $mod . '/tpl/';
    $html -> compile_dir  = CONF_HOME . 'smarty/templates_c/' . $mod . '/';
    $html -> config_dir   = CONF_HOME . 'smarty/configs/' . $mod . '/';
    $html -> cache_dir    = CONF_HOME . 'smarty/cache/' . $mod . '/';


    if ($retornar) {
        return $txt;
    }
}

function directorio($pwd) {
    // crea directorio si no existe
    if (!(file_exists($pwd))) {
        if (!(@mkdir($pwd))) {
            echo "no existe $pwd  ni lo puedo crear";
            exit;
        }
    }
}

function baseModulo($mod) {
    
    global $home;
    if ((file_exists($home . 'mods/' . $mod."/"))) {
        return $home;
    } else {
        if (defined('BASEAPP') && (file_exists(BASEAPP . "mods/" . $mod."/"))) {
            return BASEAPP;
        } else {            
            return fase;
        }
    }
}

function golog($txt, $extra = false) {
    global $usuario, $cnx;
    /*
      CREATE TABLE registro(
      fecha timestamp,
      usuario int(11),
      ip char(15),
      proxy varchar(60) default NULL,
      txt varchar(250),
      extra varchar(250) default NULL
      );

     */
    if ($extra) {
        $c = ",extra";
        $w = " , \"" . addslashes($extra) . "\" ";
    } else {
        $c = "";
        $w = "";
    }
    if ($_SERVER["HTTP_X_FORWARDED_FOR"] != "") {
        $c .= ",proxy";
        $w .= ",\"" . addslashes($_SERVER["HTTP_X_FORWARDED_FOR"]) . "\" ";
    }

    $sql = "insert into registro (fecha,usuario,ip,txt$c)
  VALUES (now()," . $usuario -> id . ",\"" . addslashes($_SERVER["REMOTE_ADDR"]) . "\",\"" . addslashes($txt) . "\"$w ) 
  
  ";
    mysqli_query($cnx, $sql);
}

function fecha($string, $hora = false) {

    if ($hora)
        $datetime = DateTime::createFromFormat('d/m/Y H:i', $string);
    else
        $datetime = DateTime::createFromFormat('d/m/Y', $string);

    //return $datetime -> format(DateTime::W3C );
    return $datetime -> format('Y-m-d H:i:s');
    //return $datetime->format('d-m-Y');
}

function cadenaAleatoria($length = 10) {
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string($d)) {
        return utf8_encode($d);
    }
    return $d;
}

function debug($variable = null) {
    global $config_debug;

    if (!$variable) {
        if ($config_debug && isset($_GET['debug']) && $_GET['debug'] == 1)
            return true;
        else
            return false;
    } else {
        if (debug())
            var_dump($variable);
    }
}

function getIP($external = true) {

    static $last_seen = '';

    if (!empty($last_seen))
        return $last_seen;

    if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
        $user_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if ($_SERVER["HTTP_CLIENT_IP"]) {
        $user_ip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        $last_seen = $_SERVER["REMOTE_ADDR"];
        return $last_seen;
    }

    $ips = preg_split('/[, ]/', $user_ip, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($ips as $last_seen) {
        if (preg_match('/^[1-9]\d{0,2}\.(\d{1,3}\.){2}[1-9]\d{0,2}$/s', $last_seen) && !isPrivateIP($last_seen)) {
            return $last_seen;
        }
    }

    $last_seen = $_SERVER["REMOTE_ADDR"];
    return $last_seen;
}

function isIPIn($ip, $net, $mask) {
    $lnet      = ip2long($net);
    $lip       = ip2long($ip);
    $binnet    = str_pad(decbin($lnet), 32, "0", "STR_PAD_LEFT");
    $firstpart = substr($binnet, 0, $mask);
    $binip     = str_pad(decbin($lip), 32, "0", "STR_PAD_LEFT");
    $firstip   = substr($binip, 0, $mask);
    return(strcmp($firstpart, $firstip) == 0);
}

function isPrivateIP($ip) {
    $privates = array("127.0.0.0/24", "10.0.0.0/8", "172.16.0.0/12", "192.168.0.0/16");
    foreach ($privates as $k) {
        list($net, $mask) = preg_split("#/#", $k);
        if (isIPIn($ip, $net, $mask)) {
            return true;
        }
    }
    return false;
}

/**
 * Convert an IP address from string/presentation format to decimal(39.0) format
 * See: http://stackoverflow.com/questions/1120371/how-to-convert-ipv6-from-binary-for-storage-in-mysql
 */
function inet_ptod($ip_address) {

    if (empty($ip_address)) {
        return 0;
    }

    // IPv4 address
    if (strpos($ip_address, ':') === false && strpos($ip_address, '.') !== false) {
        return sprintf("%u", ip2long($ip_address));
    }

    // IPv6 address
    $packed_ip = inet_pton($ip_address);
    if ($packed_ip === FALSE) {
        syslog(LOG_INFO, "Bad ip address in inet_pton: $ip_address X-Forwarded: " . $_SERVER["HTTP_X_FORWARDED_FOR"]);
        return 0;
    }

    $parts = unpack('N*', $packed_ip);

    foreach ($parts as &$part) {
        if ($part < 0) {
            $part = bcadd((string) $part, '4294967296');
        }
        if (!is_string($part)) {
            $part = (string) $part;
        }
    }
    bcscale(0);
    $decimal = $parts[4];
    $decimal = bcadd($decimal, bcmul($parts[3], '4294967296'));
    $decimal = bcadd($decimal, bcmul($parts[2], '18446744073709551616'));
    $decimal = bcadd($decimal, bcmul($parts[1], '79228162514264337593543950336'));

    return $decimal;
}

/**
 * Convert an IP address from decimal to presentation format
 */
function inet_dtop($decimal) {
    // Decimal format
    bcscale(0);
    $parts    = array();
    $parts[1] = bcdiv($decimal, '79228162514264337593543950336', 0);
    $decimal  = bcsub($decimal, bcmul($parts[1], '79228162514264337593543950336'));
    $parts[2] = bcdiv($decimal, '18446744073709551616', 0);
    $decimal  = bcsub($decimal, bcmul($parts[2], '18446744073709551616'));
    $parts[3] = bcdiv($decimal, '4294967296', 0);
    $decimal  = bcsub($decimal, bcmul($parts[3], '4294967296'));
    $parts[4] = $decimal;

    foreach ($parts as &$part) {
        if (bccomp($part, '2147483647') == 1) {
            $part = bcsub($part, '4294967296');
        }

        $part = (int) $part;
    }

    $network    = pack('N4', $parts[1], $parts[2], $parts[3], $parts[4]);
    $ip_address = inet_ntop($network);

    // Turn IPv6 to IPv4 if it's IPv4
    if (preg_match('/^::\d+.\d+.\d+.\d+$/', $ip_address)) {
        return substr($ip_address, 2);
    }

    return $ip_address;
}

function curPageURL() {
    //http://stackoverflow.com/questions/20627245/redirect-to-the-same-page-after-log-out
    $pageURL = 'http';
    if ($_SERVER["SERVER_PORT"] == "443") {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    return $pageURL;
}

function friendly_url($s) {
    $s = preg_replace("/[äáàâãª]/", "a", $s);
    $s = preg_replace("/[ÄÁÀÂÃ]/", "A", $s);
    $s = preg_replace("/[ÏÍÌÎ]/", "I", $s);
    $s = preg_replace("/[ïíìî]/", "i", $s);
    $s = preg_replace("/[ëéèê]/", "e", $s);
    $s = preg_replace("/[ËÉÈÊ]/", "E", $s);
    $s = preg_replace("/[öóòôõº]/", "o", $s);
    $s = preg_replace("/[ÖÓÒÔÕ]/", "O", $s);
    $s = preg_replace("/[üúùû]/", "u", $s);
    $s = preg_replace("/[ÜÚÙÛ]/", "U", $s);
    $s = preg_replace("/[çÇ]/", "c", $s);
    $s = preg_replace("/[ñÑ]/", "n", $s);
    $s = preg_replace("[()¿?!¡/_´'&,:-=+#.;%@]", "", $s);
    $s = str_replace('?', "", $s);
    $s = str_replace('¿', "", $s);
    $s = str_replace('"', "", $s);
    $s = str_replace('[', "", $s);
    $s = str_replace(']', "", $s);
    $s = str_replace("\\", "", $s);
    $s = preg_replace('/\b.{1,3}\b/', ' ', $s);
    $s = preg_replace('/\s\s+/', '-', $s);
    $s = trim($s);
    $s = strtolower(str_replace(" ", "-", $s));

    return $s;
}

function implode_wrapped($before, $after, $array, $glue = '') {
    return $before . implode($after . $glue . $before, $array) . $after;
}

?>