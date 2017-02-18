<?php

    $email            = isset($email)? $email: "";
    $password         = isset($password)? $password: "";
    $confirm_password = isset($confirm_password)? $confirm_password: "";

?>

<div class="container">

    <div class="row">
        <div id="card-create-user-account" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Criar minha conta</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite seu endereço de e-mail e crie uma senha.</h6>
            </div>
            <div class="card-block">
                <form method="post" action="">
                    <div class="form-group <?=isset($errors["email"])? "has-danger": "" ?>">
                        <input id="input-email" class="form-control form-control-lg <?=isset($errors["email"])? "form-control-danger": "" ?>"
                            name="email" type="text" placeholder="usuario@dominio.com" value="<?=$email ?>">
                        <?php if (isset($errors["email"])) { ?>
                            <div class="form-control-feedback"><?=$errors["email"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group <?=isset($errors["password"])? "has-danger": "" ?>">
                        <input id="input-password" class="form-control form-control-lg <?=isset($errors["password"])? "form-control-danger": "" ?>" 
                            name="password" type="password" placeholder="Senha" value="<?=$password ?>">
                        <?php if (isset($errors["password"])) { ?>
                            <div class="form-control-feedback"><?=$errors["password"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group <?=isset($errors["confirm_password"])? "has-danger": "" ?>">
                        <input id="input-confirm-password"  class="form-control form-control-lg <?=isset($errors["confirm_password"])? "form-control-danger": "" ?>"
                            name="confirm_password" type="password" placeholder="Confirme sua senha" value="<?=$confirm_password ?>">
                        <?php if (isset($errors["confirm_password"])) { ?>
                            <div class="form-control-feedback"><?=$errors["confirm_password"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Criar conta</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>

</div>

<style>

    #card-create-user-account {
        margin-top: 30px;
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
            $("#input-confirm-password").focus();
            e.preventDefault();
        });

        $("#input-confirm-password").enterKey(function(e)
        {
            $("form").submit();
        });

    });

</script> 