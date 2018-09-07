{if $msg}
<div class="alert alert-success">{$msg}</div>
{/if}

<div class=container style="margin-top: 100px;">
    <div class="jumbotron">
        <div class="container">
            <h1>{$titulopagina}</h1>
        
        <div class="container">
            <div class=row>
                
                <div class="container container-table">
                    <div class="row vertical-center-row">
                        <div class="text-center col-md-4 col-md-offset-4" id="loginbox" >
                            <div align="left">
                                <h2>Entrar</h2>
                                
                                <form action="/" role="search" class="form-horizontal"  class="navbar-form navbar-right" method="post">
                                
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Email:</label>
                                    <div class="col-sm-10">
                                      <input type="text" placeholder="Email" name="introemail" id="email" name="email" class="form-control" value="{$introemail}">
                                    </div>
                                  </div>                
                                
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Password:</label>
                                    <div class="col-sm-10">
                                      <input type="password" placeholder="Password" name="intropwd" id="pwd" name="pwd" class="form-control">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                    <div class="col-sm-2"></div>                    
                                    <div class="col-sm-10">
                                      <button class="btn btn-info " role="button"><i class="fa fa-sign-in"></i> Entrar</button>
                                    </div>
                                  </div>                    
                                    
                                    
                                </form>        
                            
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
