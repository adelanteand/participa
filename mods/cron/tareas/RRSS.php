<?php

$carpeta = realpath(dirname(__FILE__));
require_once ($carpeta . "/../../../config.php");
require_once BASEAPP . 'vendor/autoload.php'; //COMPOSER BASE
require_once BASEAPP . 'clases/funciones.php'; //FUNCIONES BASE


use Abraham\TwitterOAuth\TwitterOAuth;

importclass("RRSS",BASEAPP);

$db = new MysqliDb(Array(
    'host'     => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PWD,
    'db'       => DB_DB,
    'port'     => DB_PORT,
    'prefix'   => DB_PREFIX,
    'charset'  => 'utf8'));



/* * *****************************************************************************
 * DEBUG
 * Formato Array: 
 * array (
  'tw' =>
  array (
  'usuarios' =>
  array (
  0 => 'uno',
  1 => 'dos',
  2 => 'tres',
  ),
  'retweets' => true,
  'replies' => true,
  'count' => 3,
  ),
  'telegram' => 1234567,
  );
 * 
 * **************************************************************************** */

if (php_sapi_name() === 'cli'){
    $seguimiento = $argv[2];
} else {
    $seguimiento = $_GET['seguimiento'];
}


/*
 * OBTENEMOS EL ID SEGUIMIENTO
 */

$db->where("id",$seguimiento);
$row = $db->getOne('RRSS_seguimiento', null);



$idseguimiento = $row['id'];
$tipo          = $row['tipo'];

/* * *****************************************************************************
 * TWITTER
 * **************************************************************************** */

if ($tipo == 'tw') {

    
    $db->where("id_seguimiento",$idseguimiento);
    $row = $db->getOne('RRSS_seguimiento_tipo_tw', null);

    if ($row) {
        $count    = $row['count'];
        $retweets = $row['retweets'];
        $replies  = $row['replies'];
    } else {
        exit;
    }

    $connection = new TwitterOAuth(TW_CONSUMERKEY, TW_CONSUMERSECRET, TW_ACCESSTOKEN, TW_SECRET);
    $content    = $connection -> get("account/verify_credentials");


    $db->where("id_seguimiento_twitter",$idseguimiento);
    $res = $db->get('RRSS_seguimiento_tipo_tw_usuarios', null);    

    $usuarios = [];
    foreach ($res as $row) {
        $usuarios[] = $row['user'];
    }

    $query   = [];
    $query[] = implode_wrapped("from:", NULL, $usuarios, " OR ");

    if (!$retweets) {
        $query[] = "-filter:retweets";
    }

    if (!$replies) {
        $query[] = "-filter:replies";
    }


    //TEST QUERY
    /*
      try {
      $telegram = new Longman\TelegramBot\Telegram(TELEGRAM_API, TELEGRAM_BOT);
      $result   = Request::sendMessage(['chat_id' => 40197060, 'text' => implode($query, " AND ")]);
      } catch (Longman\TelegramBot\Exception\TelegramException $e) {
      $result = Request::sendMessage(['chat_id' => 40197060, 'text' => 'ERROR: ' . $e]);
      echo $e;
      }
     */


    $statuses = $connection -> get("search/tweets", ["q" => implode($query, " AND "), "count" => $count]);

    foreach ($statuses -> statuses as $st) {

        $t['id_seguimiento'] = $idseguimiento;
        $t['RRSS']           = "tw";
        $t['IDRRSS']         = $st -> id_str;
        $t['URLRRSS']        = "https://twitter.com/statuses/" . $t['IDRRSS'];
        $t['enviado']        = 0;

        $db->where("id_seguimiento",$idseguimiento);
        $res = $db->get('RRSS_seguimiento_telegram', null);    

        $twit = new SeguimientoRRSS($t);
        foreach ($res as $row) {        
            $twit -> enviar(NULL, $row['id_telegram']);
        }
        unset($t);
    }
}

/* * *****************************************************************************
 * FACEBOOK
 * **************************************************************************** */

if ($tipo == 'fb') {

    $fb = new Facebook\Facebook([
        'app_id'                => FB_API_APP_ID,
        'app_secret'            => FB_API_APP_SECRET,
        'default_graph_version' => FB_API_APP_VERSION,
    ]);



    $db->where("id_seguimiento",$idseguimiento);
    $row = $db->getOne('RRSS_seguimiento_tipo_fb', null);

    if ($row) {
        $count = $row['count'];
    } else {
        exit;
    }


    $db->where("id_seguimiento_facebook",$idseguimiento);
    $res = $db->get('RRSS_seguimiento_tipo_fb_pages', null);    

    $usuarios = [];
    foreach ($res as $row) {    
        $pagina = $row['idpage'];

        try {

            //$data  = $fb -> get("/me/posts/?limit=".$count, FB_PAGE_ACCESS_TOKEN_PODEMOSANDALUCIA);
            $data = $fb -> get("/" . $pagina . "/posts/?limit=" . $count, FB_PAGE_ACCESS_TOKEN);

            $posts = $data -> getDecodedBody();
            //var_dump($posts['data'][0]);
        } catch (FacebookRequestException $e) {
            
        } catch (\Exception $e) {
            
        }

        foreach ($posts['data'] as $post) {

            $t['id_seguimiento'] = $idseguimiento;
            $t['RRSS']           = "fb";
            $t['IDRRSS']         = $post['id'];
            $url                 = explode("_", $t['IDRRSS']);
            $t['URLRRSS']        = "https://fb.com/" . $pagina . "/posts/" . $url[1];
            $t['enviado']        = 0;

            
            
            $db->where("id_seguimiento",$idseguimiento);
            $res = $db->get('RRSS_seguimiento_telegram', null);    

            $twit = new SeguimientoRRSS($t);            
            foreach ($res as $row) {                    
                $twit -> enviar(NULL, $row['id_telegram']);
            }
        }
    }
}
