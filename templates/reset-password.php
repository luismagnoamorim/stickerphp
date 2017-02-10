<?php

    $email = isset($email)? $email: "";

?>

<div class="container">

    <div class="row">
        <div id="card-reset-password" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Redefinir minha senha</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite seu endereço de e-mail para redefinir sua senha.</h6>
            </div>
            <div class="card-block">
                <form id="form-reset-password" method="post" action="">
                    <div class="form-group <?=isset($errors["email"])? "has-danger": "" ?>">
                        <input class="form-control form-control-lg <?=isset($errors["email"])? "form-control-danger": "" ?>" 
                            name="email" type="text" placeholder="usuario@dominio.com" value="<?=$email ?>">
                        <?php if (isset($errors["email"])) { ?>
                            <div class="form-control-feedback"><?=$errors["email"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Redefinir senha</button>
                    </div>
                    <div class="form-group text-center">
                        <a href="/login">voltar</a>
                    </div>
                </form>
            </div>
        </div> 
    </div>

</div>

<style>

    #card-reset-password {
        margin-top: 60px;
    }

</style>