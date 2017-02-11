<?php

    $email = isset($email)? $email: "";

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
                <form method="post" action="">
                    <input type="hidden" name="uri" value="<?=$uri ?>">
                    <div class="form-group <?=isset($errors["email"])? "has-danger": "" ?>">
                        <input id="input-email" class="form-control form-control-lg <?=isset($errors["email"])? "form-control-danger": "" ?>" 
                            name="email" type="text" placeholder="usuario@dominio.com" value="<?=$email ?>">
                        <?php if (isset($errors["email"])) { ?>
                            <div class="form-control-feedback"><?=$errors["email"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group <?=isset($errors["password"])? "has-danger": "" ?>">
                        <input id="input-password" class="form-control form-control-lg <?=isset($errors["password"])? "form-control-danger": "" ?>" 
                            name="password" type="password" placeholder="Senha">
                        <?php if (isset($errors["password"])) { ?>
                            <div class="form-control-feedback"><?=$errors["password"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Efetuar login</button>
                    </div>
                    <div class="form-group text-center">
                        <a href="/reset-password">Esqueci minha senha</a>
                    </div>
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

        $("#input-email").enterKey(function(e)
        {
            $("#input-password").focus();
            e.preventDefault();
        });

        $("#input-password").enterKey(function(e)
        {
            $("form").submit();
        });
        
    });

</script> 
