<div class="container">
    <div class="row">
        <div class="col-md-12">
            {if $accion=='OK'}
                <div class="alert alert-success" role="alert">
                    <h2>Enviada validada</h2>
                </div>
            {/if}

            {if $accion=='NO'}
                <div class="alert alert-danger" role="alert">
                    <h2>Enviada NO validada</h2>
                </div>
            {/if}

        </div>

    </div>

</div>