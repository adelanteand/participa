<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class Correo {

    var $titulo, $from, $fromtxt, $to, $totxt, $asunto, $oculto;

    function __construct() {
        $this->oculto = false;
    }

    function enviar($txt) {
        global $html, $home;
        $mail = new PHPMailer();

        try {

            if (SMTP_SERVER) {
                $mail->isSMTP();
                $mail->Host = SMTP_SERVER;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = false;
                $mail->Username = SMTP_USERNAME;
                $mail->Password = SMTP_PASSWORD;
                $mail->Port = SMTP_PORT;
            }


            $mail->CharSet = "UTF-8";
            $mail->IsHTML(true);

            if ($this->fromtxt) {
                $mail->SetFrom($this->from, $this->fromtxt);
            } else {
                $mail->SetFrom($this->from);
            }

            $mail->Subject = $this->asunto;

            $html->assign("asunto", $this->asunto);
            $html->assign("txt", $txt);
//
//        $mail -> AddEmbeddedImage($home.'html/img/mainlogo120.jpg', 'mainlogo');
//        $mail -> AddEmbeddedImage($home.'html/img/footlogo140.jpg', 'footlogo');

            $mail->MsgHTML(mostrartpl("email_simple.tpl", true));

            if (strpos($this->to, ',') !== false) {
                $addresses = explode(',', $this->to);
                foreach ($addresses as $address) {
                    if ($this->oculto) {
                        $mail->AddBCC($address);
                    } else {
                        $mail->AddAddress($address);
                    }
                }
            } else {
                if ($this->totxt) {
                    $mail->AddAddress($this->to, $this->totxt);
                } else {
                    $mail->AddAddress($this->to);
                }
            }
            
            
            if ($this->adjunto){
                $fichero = new Fichero ($this->adjunto);
                $mail->addAttachment($fichero->path);
            }
            
            $mail->addBCC('soporte@andaluciapodemos.info');

            $mail->Send();
            //var_dump($mail);
            
        } catch (Exception $e) {
            echo 'No se pudo enviar el email: ', $mail->ErrorInfo;
        }
    }

}
