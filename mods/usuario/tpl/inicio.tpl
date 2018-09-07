

{if $usuario.id==0}

            {if $msg}
                <div class="alert alert-success">
                    {$msg}
                </div>
            {/if}

            {if $msg_err}
                <div class="alert alert-danger">
                    {$msg_err}
                </div>
            {/if}		

            <div class="container container-table">
                <div class="row vertical-center-row">
                    <div class="text-center col-md-5 col-md-offset-1" id="loginbox" >
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3>REGISTRARSE</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="btn-group btn-group-justified">
                                        <div id="btn-registro" class="btn btn-primary" style="background-color: gray; border-color:gray"><i class="fa fa-plus" aria-hidden="true"></i> Registrarse de alta en el sistema</div>
                                    </div>
                                </div>
                                <div class="registro" style="display:none">        
                                    <form action="/usuarios/alta/" method="post" class="form-horizontal" role="form">                                    
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="email">Correo electrónico:</label>
                                            <div class="col-sm-9">                                            
                                                <input type="hidden" name="redirect" id="redirect" class="form-control" value="{$refURL}">
                                                <input type="text" placeholder="" name="email" id="email" name="email" class="form-control" value="{$introemail}">
                                                Introduzca un correo electrónico válido, pulse el botón de 'Alta de usuario' y revise su bandeja de entrada para continuar con el registro.<p></p>                                            
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-9">
                                                <button type="submit" class="btn btn-default">
                                                    Alta de usuario
                                                </button>
                                            </div>
                                        </div>
                                    </form> 
                                </div>                           

                            </div>
                        </div>
                    </div>

                    <div class="text-center col-md-5 " id="loginbox" >
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3>ACCEDER</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="btn-group btn-group-justified">
                                        <a href="{$loginUrlfb}" class="btn btn-primary"><i class="fa fa-facebook" aria-hidden="true"></i> Iniciar sesión con Facebook</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="btn-group btn-group-justified">
                                        <a href="{$loginUrlGoogle}" class="btn btn-primary" style="background: #dd4b39; border: #dd4b39"><i class="fa fa-google" aria-hidden="true"></i> Iniciar sesión con Google</a>
                                    </div>
                                </div>

                                <hr>

                                <form action="/usuarios/entrar/" method="post" class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="email">Email:</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="redirect" id="redirect" class="form-control" value="{$refURL}">
                                            <input type="text" placeholder="" name="introemail" id="email" name="email" class="form-control" value="{$introemail}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="pwd">Password:</label>
                                        <div class="col-sm-9">
                                            <input type="password" placeholder="Password" name="intropwd" id="pwd" name="pwd" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-9">
                                            <button type="submit" class="btn btn-default">
                                                Entrar
                                            </button>
                                        </div>
                                    </div>
                                </form>


                                <hr>

                                <form action="/usuarios/recordar/" method="post" class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="email">Email:</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="redirect" id="redirect" class="form-control" value="{$refURL}">
                                            <input type="text" placeholder="" name="introemail" id="email" name="email" class="form-control" value="{$introemail}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-9">
                                            <button type="submit" class="btn btn-default">
                                                Recordar clave
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        {else}

            {include file="registrado.tpl"}

        {/if}
