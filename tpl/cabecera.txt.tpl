<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="{$app_descripcion}">
        <meta name="author" content="{$app_autor}">

        <title>{$titulopagina}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>

        {foreach from=$css item=j}
            <link href="{$j}" rel="stylesheet" type="text/css" />
        {/foreach}

        {foreach from=$js item=j}{if $j}<script type='text/javascript' src='{$j}'></script>{/if}
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

        <div id="contenido">
