<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once (__DIR__ . "/../../../config.php");
require_once (__DIR__ . "/../funciones.php");

use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

//OBTENEMOS DATOS DEL MENSAJE
$message = $this->getMessage();
$chat = $message->getChat();
$chat_id = $chat->getId();
$user_id = $message->getFrom()->getId();

if ($chat_id != '-1001258220175') {
    //No estoy en el grupo adecuado, asi que me piro vampiro
    exit;
}

$data = [
    'chat_id' => $chat_id,
    'reply_markup' => Keyboard::remove(),
];

$formatos_aceptados = array("jpg", "jpeg", "bmp", "gif", "png");
$formatos_raw = array(
    "3fr", "ari", "arw", "bay", "crw", "cr2", "cr3", "cap", "data", "dcs",
    "dcr", "dng", "drf", "eip", "erf", "fff", "gpr", "iiq", "k25", "kdc",
    "mdc", "mef", "mos", "mrw", "nef", "nrw", "obm", "orf", "pef", "ptx",
    "pxn", "r3d", "raf", "raw", "rwl", "rw2", "rwz", "sr2", "srf", "srw",
    "tif", "x3f"
);

$respuestas = array(
    'More resolution please!',
    'Esto no lo subo ni jarto whisky',
    'Engaaaa la fiesta del pixel',
    '¿No la hay en peor calidad? xD',
    'Algún dia...',
    'Que recaiga toda la ira de las máquinas sobre ti',
    'Y aquí tenemos una fotito de juguete',
    'Soy un bot muy tikismikis, que le vamos a hacer...',
    'Vamos a hacer las cositas bien hechas',
    'Amo a asé las cozita bien esha omme'
);

// Start conversation
$conversation = new Conversation($user_id, $chat_id, $this->getName());
$message_type = $message->getType();



if (in_array($message_type, ['document'], true)) {
    $doc = $message->{'get' . ucfirst($message_type)}();
    $data['text'] = $doc;

    $file_id = $doc->getFileId();
    $file = Request::getFile(['file_id' => $file_id]);

    if ($file->isOk() && Request::downloadFile($file->getResult())) {
        //SUBIMOS A FLICKR        
        $ext = strtolower(pathinfo($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath(), PATHINFO_EXTENSION));
        if (in_array($ext, $formatos_aceptados)) {
            //Formato aceptado
            $urlUploaded = SubirFlickr($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath(), "Adelante Andalucía. Subida por ". $message->getFrom()->getFirstName() . " " . $message->getFrom()->getLastName());
            $data['text'] = "He subido la foto a Flickr: " . $urlUploaded;
        } elseif (in_array($ext, $formatos_raw)) {
            //Formato RAW. Necesita conversión

            $im = new Imagick($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath());
            $im->setImageFormat('jpg');
            $im->writeImage($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath() . ".jpg");
            $im->clear();
            $im->destroy();

            $urlUploaded = SubirFlickr($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath() . ".jpg", "Adelante Andalucía. Subida por ". $message->getFrom()->getFirstName() . " " . $message->getFrom()->getLastName());
            $data['text'] = "He convertido y subido la foto a Flickr: " . $urlUploaded;
        } else {
            //Formato no reconocido
            $data['text'] = "No acepto el formato. Lo siento";
        }

        //Eliminamos los originales
        if (file_exists($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath())) {
            unlink($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath());
        }
        if (file_exists($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath() . ".jpg")) {
            unlink($this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath() . ".jpg");
        }


        //$data['text'] = $message_type . ' file is located at: ' . $this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath();
    } else {
        $data['text'] = 'Me he trabucao. No he podido descargar el fichero. Sorry. Avisa a mi dueño y dile que tengo un error ';
        $data['text'] .= $file->getErrorCode() . ": " . $file->getDescription();
    }

    $conversation->notes['file_id'] = $file_id;
    $conversation->update();
    $conversation->stop();
} elseif (in_array($message_type, ['photo'], true)) {
    $data['reply_to_message_id'] = $message->getMessageId();
    $data['text'] = $respuestas[array_rand($respuestas, 1)];
} else {
    $data['text'] = "";
}

return Request::sendMessage($data);
