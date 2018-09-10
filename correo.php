<?php

require ("PHPMailer_5.2.1/class.phpmailer.php");

Class Correo {
    var $titulo, $from, $fromtxt, $to, $totxt, $asunto, $oculto;

    function Correo() {
        $this -> oculto = false;
    }

    function enviar($txt) {
        global $html,$home;
        $mail = new PHPMailer();

        $mail -> CharSet = "UTF-8";
        $mail -> IsHTML(true);

        if ($this -> fromtxt)
            $mail -> SetFrom($this -> from, $this -> fromtxt);
        else
            $mail -> SetFrom($this -> from);
        $mail -> Subject = $this -> asunto;

        $html -> assign("asunto", $this -> asunto);
        $html -> assign("txt", $txt);

        $mail -> AddEmbeddedImage($home.'html/img/mainlogo120.jpg', 'mainlogo');
        $mail -> AddEmbeddedImage($home.'html/img/footlogo140.jpg', 'footlogo');

        $mail -> MsgHTML(mostrartpl("email.tpl", true));

        if (strpos($this -> to, ',') !== false) {
            $addresses = explode(',', $this -> to);
            foreach ($addresses as $address) {
                if ($this->oculto)
                    $mail->AddBCC($address);
                else
                    $mail->AddAddress($address);
            }
        } else {
            if ($this -> totxt)
                $mail -> AddAddress($this -> to, $this -> totxt);
            else
                $mail -> AddAddress($this -> to);            
        }



        $mail -> Send();
    }

}
