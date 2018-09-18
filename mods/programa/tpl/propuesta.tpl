{include file="ScriptsRedes.tpl"}

<script>



    $(document).ready(function () {
        console.log("{$propuesta->textoplano}");
        var whatsappMessage = "*¿Qué te parece esta propuesta del programa de Adelante Andalucía?*\r\n\r\n{$propuesta->textoplano}\r\n\r\n{$app_full_url}";
        whatsappMessage = window.encodeURIComponent(whatsappMessage);
        $("#whatsapp").prop("href", "whatsapp://send?text=" + whatsappMessage);

    });

</script>


<div class="container">


    <div class="row">
        <div class="col-md-10">
            <h2><strong>{$tipo} {$propuesta->id}</strong></h2>
        </div>

        <div class="col-md-2">
            <a class="btn btn-light float-right" href="{$url_anterior}">Volver</a>
        </div>    

    </div>    



    {include file="breadcrumbs.tpl"}

    <div class="cuadro-propuesta">{$propuesta->texto}</div>

    <hr>

    <div class="row">
        <div class="col-4"><a class="btn btn-link" href="/formulario/mod/{$propuesta->id}/"><i class="fas fa-edit"></i> Proponer un modificación del texto</a></div>
        <div class="col-4"><a class="btn btn-link" href="/formulario/sup/{$propuesta->id}/" style="color:red;"><i class="fas fa-trash-alt"></i> Sugerir eliminación</a></div>
    </div>

    {if $elementotipo=='propuesta'}
        <div class="row float-right">
            <div class="social-share">

                <a href="" id="whatsapp" class="btn btn-sm btn-primary whatsapp"><i class="fab fa-whatsapp"></i> Compartir en Whatsapp</a>


                <a class="twitter-share-button"
                   data-text="¿Qué os parece esta propuesta? {$propuesta->acortada}"
                   data-hashtags="AdelanteAndalucia"
                   data-url="{$app_full_url}"
                   href="https://twitter.com/intent/tweet"
                   data-size="large"
                   style="vertical-align:top;zoom:1;*display:inline">
                    Twitter</a>

                <div class="fb-share-button" data-href="{$app_full_url}" data-layout="button" data-size="large" data-mobile-iframe="true" style="vertical-align:top;zoom:1;*display:inline">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Facebook</a>
                </div>              

            </div>
        </div>
    {/if}
    
    <hr>

    {if $propuesta->enmiendas}
        <h4><strong><i class="fas fa-comment-dots"></i> Enmiendas recibidas</strong></h4>
        {foreach from=$propuesta->enmiendas item=e}
            {include file="enmienda.tpl"}
        {/foreach}
    {/if}

</div>