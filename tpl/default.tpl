<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{$app_descripcion}">
        <meta name="author" content="{$app_autor}">

        <title>{$titulopagina}</title>

        <!-- Bootstrap core CSS -->                        
        <link href="/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>        
        <link href="/vendor/@fortawesome/fontawesome-free/css/fontawesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/css/theme.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">

        <!-- ICONOS -->
        <link rel="apple-touch-icon" sizes="57x57" href="/img/icon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/img/icon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/img/icon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/img/icon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/img/icon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/img/icon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/img/icon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/img/icon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/img/icon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/img/icon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
        <link rel="manifest" href="/img/icon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/img/icon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->        

        <script src="/vendor/jquery/dist/jquery.min.js" type="text/javascript"></script>
        <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="/vendor/@fortawesome/fontawesome-free/js/all.min.js" type="text/javascript"></script>
        <script src='/vendor/tinymce/tinymce.min.js'></script>
        <script src='/vendor/tinymce-i18n/langs/es.js'></script>



        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

        {foreach from=$css item=j}
            <link href="{$j}" rel="stylesheet" type="text/css" />
        {/foreach}

        {foreach from=$js item=j}
            {if $j}
                <script type='text/javascript' src='{$j}'></script>
            {/if}
        {/foreach}

        <!-- REDES SOCIALES META -->
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        <meta property="og:type"               content="article" />
        <meta property="og:url"                content="{$app_full_url}" />
        <meta property="fb:app_id"             content="{$fb_api_app_id}" />
        <meta property="og:title"              content="{$app_titulopagina}" />
        <meta property="og:description"        content="{$app_descripcion}" />
        <meta property="og:image"              content="{$app_fb_image}" />
        <meta property="og:image:width"        content="{$app_fb_image_w}" />
        <meta property="og:image:height"       content="{$app_fb_image_h}" />
        <meta property="twitter:description"   content="{$app_descripcion}" />
        <meta property="twitter:title"         content="{$app_titulopagina}" />
        <meta property="twitter:image"         content="{$app_tw_image}" />
        <meta property="twitter:site"          content="{$app_tw_user}" />
        <meta property="twitter:card"          content="summary" />       
    </head>


    <body>

        <!-- Scripts en body -->

        {if isset($scriptbody)}
            {foreach from=$scriptbody item=j}
                {if $j}
                    <script type='text/javascript' src='{$j}'></script>
                {/if}
            {/foreach}
        {/if}        



        <nav class="navbar navbar-expand-md navbar-dark fixed-top navbar-custom">

            <a class="navbar-brand" href="/{if isset($colectivos)}?colectivos=1{/if}"><img class="img-responsive" width="150" src="{$conf_logo}"/></a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <!--
                    <li class="nav-item active">
                    {if ($version=='default')}
                    <a class="nav-link" href="/patios/">Versión navegable<span class="sr-only"></span></a>
                    {else}
                    <a class="nav-link" href="/">Versión interactiva<span class="sr-only"></span></a>
                    {/if}
                </li>
                    -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/consultas/">Consulta directa<span class="sr-only"></span></a>
                    </li>                    
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>-->
                </ul>    

                <form class="form-inline mt-2 mt-md-0" style="margin-right:10px">
                    <a href="https://adelanteandalucia.org/" class="btn btn-light"><i class="fas fa-external-link-alt"></i> Adelante Andalucía</a>
                </form>                 
                <form class="form-inline mt-2 mt-md-0" style="margin-right:10px">
                    <a href="https://adelanteandalucia.org/sites/default/files/ReglamentoPatios.pdf" target="_blank" class="btn btn-info"><i class="fas fa-file-alt"></i> Reglamento</a>
                </form>                
                <form class="form-inline mt-2 mt-md-0" style="margin-right:10px">
                    <a href="https://adelanteandalucia.org/sites/default/files/ProgramaBorrador.pdf" target="_blank" class="btn btn-danger"><i class="fas fa-file-alt"></i> Descargar borrador PDF</a>
                </form>
            </div>
        </nav>

        {include file="$plantilla"}



        {foreach from=$jspie item=j}
            <script type='text/javascript' src='{$j}'></script>
        {/foreach}                

    </body>
</html>