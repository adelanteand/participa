<!DOCTYPE html>
<html lang="es">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="{$app_descripcion}">
        <meta name="author" content="{$app_autor}">

        <title>{$titulopagina}</title>

        <!-- Bootstrap core CSS -->        
        <link href="/plugins/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">-->
        <link href="/css/theme.css" rel="stylesheet">
        <link href="/plugins/fortawesome/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="/plugins/select2/select2/dist/css/select2.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker3.css" rel="stylesheet" />
        
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
        <meta http-equiv="Pragma" content="no-cache">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="/plugins/components/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="/plugins/twbs/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/plugins/select2/select2/dist/js/select2.min.js" type="text/javascript"></script>        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/locales/bootstrap-datepicker.es.min.js"></script>
        

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

        <!-- Google Analytics -->
        {literal}
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] ||
                            function () {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-70367044-2', 'auto');
                ga('send', 'pageview');

            </script>
        {/literal}

        <header>

            <div class="navbar navbar-default navbar-fixed-top">
                <section class="top-links show-for-medium-up">
                    <div class="row">
                        <div class="locale" id="js-locale" data-current-local="es"></div>

                        <div class="external-links">

                        </div>
                    </div>
                </section>

                <div class="container">

                    <div class="navbar-header">
                        <a href="/" class="navbar-brand"><h2>{$organizacion}</h2></a>
                    </div>

                    <center>
                        <div id="navbar-main" class="navbar-collapse collapse" style="height: 1px;">
                            <ul class="nav navbar-nav">

                            </ul>

                            {if $usuario.id==0}

                                <div class="navbar-form navbar-right">
                                    <a href="/usuarios/?redirect={$refURL}" class="btn btn-info" role="button"><i class="fa fa-sign-in"></i> Entrar</a>
                                </div>

                            {else}

                                <div class="navbar-form navbar-right">
                                    <a href="/usuarios/" class="btn btn-info" id="cuadrousuario" style="padding-right:10px;"> {$usuario.fullName}

                                        {if $usuario.avatar neq ""} <img src="{$usuario.avatar}"  width="25"/> {else} <img width="25" data-name="{$usuario.fullName}" class="iniciales img-circle"/> {/if} </a>
                                    <a href="/usuarios/salir/?redirect={$refURL}" class="btn btn-info" role="button"><i class="fa fa-sign-out"></i> Salir</a>
                                </div>

                            {/if}

                        </div>

                    </center>

                </div>

                <section class="subnavigation ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="topnav">
                                    {foreach from=$menu item=m}
                                    <li>
                                        <a href="{$m->enlace}" class="{if $mod|lower == $m->modulo|lower}active{/if}">{if $m->icono != ""}<i class="fa {$m->icono}" aria-hidden="true"></i>{/if} {$m->titulo}</a>
                                    </li>
                                    {/foreach}
                                    <li class="usuario">
                                    {if $usuario.id==0}
                                        <hr>
                                        <a href="/usuarios/?redirect={$refURL}" ><i class="fa fa-sign-in"></i> Entrar</a>
                                    {else}
                                        <hr>
                                        <a href="/usuarios/salir/?redirect={$refURL}" class="btn btn-info" role="button"><i class="fa fa-sign-out"></i> Salir</a>
                                    {/if}
                                    </li>
                                    <li class="barras">
                                        <a href="javascript:void(0);" onclick="responsive()"><i class="fa fa-bars" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </header>

        <div id="contenido">

