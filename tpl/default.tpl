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
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
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
            <a class="navbar-brand" href="#"><img class="img-responsive" width="150" src="{$conf_logo}"/></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
                <form class="form-inline mt-2 mt-md-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

        {include file="$plantilla"}


        <!--
        
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">{$organizacion}</a>
            <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">                    
        {if $usuario.id==0}                    
            <a href="/usuario/login/?redirect={$refURL}" class="nav-link" role="button"><i class="fa fa-sign-in"></i> Entrar <i class="fas fa-sign-in-alt" aria-hidden="true"></i></a>
        {else}
        <a href="/usuario/"  class="nav-link" > {$usuario.fullName}</a>                        
            {if $usuario.avatar neq ""}                             
                <img src="/media/{$media->modulo}/{$media->modid}/?w=25&{$random}" width="25" class="img-circle"/> 
            {else} 
                <img width="25" data-name="{$usuario.fullName}" class="iniciales img-circle"/> 
            {/if}
            </a>
        {/if}
    </li>

</ul>
        {if $usuario.id!=0}    
            <ul class="navbar-nav px-3" style="background-color:red;padding: 6px;" >
                <li class="nav-item text-nowrap" >  
                    <a href="/usuario/salir/?redirect={$refURL}" class="nav-link"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>                    
                </li>
            </ul>
        {/if}
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
        {foreach from=$menu item=m}
            <li class="nav-item">
                <a href="{$m->enlace}" class="nav-link {if $mod|lower == $m->modulo|lower}active{/if}">{if $m->icono != ""}
                    <i class="fa {$m->icono}" aria-hidden="true"></i>{/if}
            {$m->titulo}
        </a>
    </li>
        {/foreach}                   


        <li class="nav-item">



        </li>


    </ul>




</div>
</nav>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h2">{$mod}</h2>
        {if isset($botones) && $botones==true}
            <div class="btn-toolbar">
            {include file="{$botones}"}
        </div>
        {/if}   

    </div>
    
</main>
</div>
</div>
        -->

        {foreach from=$jspie item=j}
            <script type='text/javascript' src='{$j}'></script>
        {/foreach}                

    </body>
</html>