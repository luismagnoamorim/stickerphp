<?php

    $uri = isset($_GET["uri"])? $_GET["uri"]: "/stickerbooks";

?>
<div class="container">
    <div class="row">
        <div id="card-login" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Login</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite seu endereço de e-mail e sua senha.</h6>
            </div>
            <div class="card-block">
                <form id="form-login" method="post" action="">
                    <input type="hidden" name="uri" value="<?=$uri ?>">
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" name="email" type="email" placeholder="usuario@dominio.com">
                    </fieldset>
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" name="password" type="password" placeholder="Senha">
                    </fieldset>
                    <fieldset class="form-group">
                        <a id="link-login" href="#" role="button" class="btn btn-primary btn-lg btn-block">Efetuar login</a>
                    </fieldset>
                    <fieldset class="form-group text-center">
                        <a href="/reset-password">Esqueci minha senha</a>
                    </fieldset>
                </form>     
            </div>
        </div> 
    </div>
</div>

<style>

    #card-login {
        margin-top: 60px;
    }

</style>

<script type="text/javascript">

    $(document).ready(function()
    {
        
        $("#link-login").click(function()
        {
            $("#form-login").submit();
        });

    });

</script>

