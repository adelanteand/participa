        </div>

        <div id="footer" class="footer " >
            <div class="container">

                <div class="row">
                    <div class="col-md-9">
                        {$organizacion}
                    </div>
                    
                    <div class="col-md-3">
                    </div>			

                </div>

            </div>
        </div>

        {foreach from=$jspie item=j}
            <script type='text/javascript' src='{$j}'></script>
        {/foreach}

    </body>
</html>
