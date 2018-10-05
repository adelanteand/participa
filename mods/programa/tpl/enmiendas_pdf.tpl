
{$nivel=5}
<div id="container">
    <div id="row">

        <span class="float-center"><h1>{$texto_libre}</h1></span>

        {foreach $programa as $categoria}
            <div style="border: 2px solid;" class="mt-2 mb-2 p-2">
                <h2><strong>{$categoria->id}</strong> {$categoria->nombre}</h2>

                {if $categoria->intro}                
                    {$primeraVez=true}
                    {foreach $categoria->intro as $parrafo}
                        {if $parrafo->enmiendas}     
                            {if $primeraVez}
                                <h5><strong><i class="far fa-arrow-alt-circle-right"></i> Enmiendas al texto introductorio</strong></h5>
                                {$primeraVez=false}
                            {/if}                        
                            <p class="ml-4"><span class="badge badge-secondary"><a style="color:white" href="/parrafo/{$parrafo->id}/" target="_blank">Párrafo {$parrafo->id}:</a></span> {$parrafo->texto}</p>
                            {foreach $parrafo->enmiendas as $e}        
                                {$nivel=5}
                                <span>{include file="enmiendas_pdf_suelta.tpl"}</span>
                            {/foreach}                                            
                        {/if}
                    {/foreach}
                {/if}

                {if $categoria->enmiendas}
                    <h5><strong><i class="far fa-arrow-alt-circle-right"></i> Enmiendas de adición a la categoría </strong></h5>
                    {foreach $categoria->enmiendas as $e}
                        <div class="p-2 ml-4 mb-2" style="border: 2px solid">
                        {$nivel=2}
                        <span>{include file="enmiendas_pdf_suelta.tpl"}</span>
                        </div>
                    {/foreach}
                {/if}

                {if $categoria->propuestas}                
                    {$primeraVez=true}
                    {foreach $categoria->propuestas as $propuesta}                    
                        {if $propuesta->enmiendas}
                            {if $primeraVez}
                                <h5><strong><i class="far fa-arrow-alt-circle-right"></i> Enmiendas de modificación o supresión a las propuestas</strong></h5>
                                {$primeraVez=false}
                            {/if}
                            <div class="p-2 ml-4  mb-2" style="border: 2px solid">
                                <p ><span class="badge badge-secondary"><a style="color:white" href="/propuesta/{$propuesta->id}/" target="_blank">Propuesta {$propuesta->id}:</a></span> {$propuesta->texto}</p>
                            {foreach $propuesta->enmiendas as $e}
                                {$nivel=5}
                                <span>{include file="enmiendas_pdf_suelta.tpl"}</span>
                            {/foreach}
                             </div>
                        {/if}             
                    {/foreach}
                {/if}                        
            </div>


            <p></p>                
        {/foreach}        

    </div>
</div>

