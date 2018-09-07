<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <title>{$titulopagina}</title>
    <style>
            {literal}
            body {
                color: #000;
                font-size: 12pt;
                margin: 0;
                background-color: #fff;
            }
            h1 {
                font-size: 20pt;
                padding: 0px;
                margin: 0px 0px 10pt 0px;
            }
            .sup h1 {
                color: #682F64;
            }
            .sup {
                color: #008c82;
                padding: 5px;
                text-align: center;
            }
            .txt {
                background: #eee;
                border-radius: 5px;
                border: 1px solid #aaa;
                padding: 20px;
                margin: 15px;
            }
            .pie {
                padding: 5px;
                border-top: 1px solid #fff;
                font-size: 10pt;
            }{/literal}
        </style>
</head>
<body>
        <div class="sup">
        
            <img src="cid:mainlogo" alt="{$titulopagina}"/>
<br>
            
            <h1>{$titulopagina}</h1>
            <h2>{$asunto}</h2>
            
            

        </div>
        <div class="txt">
            {$txt}
        </div>
        <div class="pie">
            <hr>
            <p><strong>{$titulopagina}</strong>
            <br>
            <a href="{$urlreferencia}">{$urlreferencia}</a>
            <br>
            <a href="mailto:{$siteadmin}">{$siteadmin}</a>
            </p>
            <p><img src="cid:footlogo" alt="Podemos Andalucía" /><br>
            {if $clavemd}
            Si desea darse de baja o modificar sus intereses siga el siguiente enlace:
            <br>
            <a href="{$baseurl}subscripcion/vermd/{$clavemd}/"> {$baseurl}subscripcion/vermd/{$clavemd}/ </a>
            <br>
            <img src="{$baseurl}mailing/vermd/{$clavemd}/">
            {/if}

            </p>
        </div>
</body>
</html>