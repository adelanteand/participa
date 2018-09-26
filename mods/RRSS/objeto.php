<?php

$carpeta = realpath(dirname(__FILE__));
require_once ($carpeta . "/../../config.php");
require_once BASEAPP . 'vendor/autoload.php'; //COMPOSER BASE

use Longman\TelegramBot\Request;

importclass("entidad",BASEAPP);

$db = new MysqliDb(Array(
    'host'     => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PWD,
    'db'       => DB_DB,
    'port'     => DB_PORT,
    'prefix'   => DB_PREFIX,
    'charset'  => 'utf8'));

Class SeguimientoRRSS extends Entidad {

    var $id = 0;
    
    private $datos = array(
        'tabla' => "RRSS_seguimiento_log",
        'manuales' => array(
            'id_seguimiento',
            'RRSS',
            'IDRRSS',
            'URLRRSS',
            'enviado'
        )
    );

    function __construct($id = 0) {
        parent::__construct($id, $this->datos);
    }    

    function enviar($textoAdicional = NULL, $usuarioTelegram = TELEGRAM_ADMINLOG) {

        global $db; 
        if (!isset($this->enviado)) {

            global $bd_host, $bd_user, $bd_password;
            
            $db->where("username",$usuarioTelegram);
            $db->orWhere("id",$usuarioTelegram);            
            $row = $db->getOne('telegram_chat', null);                
            
            if ($row) {
                $chat_id = $row['id'];
            }
            
            try {
                $telegram        = new Longman\TelegramBot\Telegram(TELEGRAM_API, TELEGRAM_BOT);
                $result          = Request::sendMessage(['chat_id' => $chat_id, 'text' => $textoAdicional . "\n" . $this -> URLRRSS]);
                $this -> enviado = 1;
                $this -> actualizar();
            } catch (Longman\TelegramBot\Exception\TelegramException $e) {
                $result = Request::sendMessage(['chat_id' => TELEGRAM_ADMINLOG, 'text' => 'ERROR: ' . $e]);
                echo $e;
            }
        }
    }

    function actualizar() {        
        global $db;

//        foreach ($this as $key => $value) {
//            if (!in_array($key, array('ID', 'created_at'))) {
//                $value     = mysqli_real_escape_string($cnx, $value); // this is dedicated to @Jon
//                $value     = "'$value'";
//                $updates[] = "$key = $value";
//            }
//        }
//
//        $implodeArray = implode(', ', $updates);
//        

        $this->enviado = 1;
        $data = Array (
                'enviado' => $this->enviado
        );        
        $db->where ('id', $this->id);
        if (!$db->update ('RRSS_seguimiento_log', $data)){
            $db->getLastQuery();
            $db->getLastError();
        }        
    }

}
