<div class="container">
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingAlmeria">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#grupoAlmeria" aria-expanded="true" aria-controls="grupoAlmeria">
                        Almería
                    </button>
                </h5>
            </div>

            <div id="grupoAlmeria" class="collapse show" aria-labelledby="headingAlmeria" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/almeria.tpl"}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingCadiz">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoCadiz" aria-expanded="false" aria-controls="grupoCadiz">
                        Cádiz
                    </button>
                </h5>
            </div>
            <div id="grupoCadiz" class="collapse" aria-labelledby="headingCadiz" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/cadiz.tpl"}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingCordoba">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoCordoba" aria-expanded="false" aria-controls="grupoCordoba">
                        Córdoba
                    </button>
                </h5>
            </div>
            <div id="grupoCordoba" class="collapse" aria-labelledby="headingCordoba" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/cordoba.tpl"}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingGranada">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoGranada" aria-expanded="false" aria-controls="grupoGranada">
                        Granada
                    </button>
                </h5>
            </div>
            <div id="grupoGranada" class="collapse" aria-labelledby="headingGranada" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/granada.tpl"}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingHuelva">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoHuelva" aria-expanded="false" aria-controls="grupoHuelva">
                        Huelva
                    </button>
                </h5>
            </div>
            <div id="grupoHuelva" class="collapse" aria-labelledby="headingHuelva" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/huelva.tpl"}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingJaen">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoJaen" aria-expanded="false" aria-controls="grupoJaen">
                        Jaén
                    </button>
                </h5>
            </div>
            <div id="grupoJaen" class="collapse" aria-labelledby="headingJaen" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/jaen.tpl"}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingMalaga">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoMalaga" aria-expanded="false" aria-controls="grupoMalaga">
                        Málaga
                    </button>
                </h5>
            </div>
            <div id="grupoMalaga" class="collapse" aria-labelledby="headingMalaga" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/malaga.tpl"}
                </div>
            </div>
        </div>          
        <div class="card">
            <div class="card-header" id="headingSevilla">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#grupoSevilla" aria-expanded="false" aria-controls="grupoSevilla">
                        Sevilla
                    </button>
                </h5>
            </div>
            <div id="grupoSevilla" class="collapse" aria-labelledby="headingSevilla" data-parent="#accordion">
                <div class="card-body">
                    {include file="patios/sevilla.tpl"}
                </div>
            </div>
        </div>     
    </div>
</div>