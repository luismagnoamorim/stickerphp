<?php

    $email = isset($email)? $email: "";

?>

<div class="container">
    
    <div class="row">
        <div id="card-create-user-account" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Criar novo álbum</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite as informações do novo álbum.</h6>
            </div>
            <div class="card-block">
                <form method="post" action="/admin/create-stickerbook/">
                    <div class="form-group <?=isset($errors["email"])? "has-danger": "" ?>">
                        <input id="titulo" class="form-control form-control-lg <?=isset($errors["titulo"])? "form-control-danger": "" ?>"
                            name="titulo" type="text" placeholder="Título do álbum" value="<?=$email ?>">
                        <input id="editora" class="form-control form-control-lg <?=isset($errors["editora"])? "form-control-danger": "" ?>"
                            name="editora" type="text" placeholder="Editora" value="<?=$email ?>">
                        <input id="anoPublicacao" class="form-control form-control-lg <?=isset($errors["anoPublicacao"])? "form-control-danger": "" ?>"
                            name="anoPublicacao" type="text" placeholder="Ano de publicação" value="<?=$email ?>">
                        <input id="idioma" class="form-control form-control-lg <?=isset($errors["idioma"])? "form-control-danger": "" ?>"
                            name="idioma" type="text" placeholder="Idioma" value="<?=$email ?>">                            
                        <input id="quantidadeCromo" class="form-control form-control-lg <?=isset($errors["quantidadeCromo"])? "form-control-danger": "" ?>"
                            name="quantidadeCromo" type="text" placeholder="Quantidade total de cromos" value="<?=$email ?>">
                        <input id="nomeImagem" class="form-control form-control-lg <?=isset($errors["nomeImagem"])? "form-control-danger": "" ?>"
                            name="nomeImagem" type="text" placeholder="Nome da imagem de capa" value="<?=$email ?>">
                        <?php if (isset($errors["titulo"])) { ?>
                            <div class="form-control-feedback"><?=$errors["titulo"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Criar Álbum</button>
                    </div>
                </form>     
            </div>
        </div> 
    </div>

</div>

<style>

    #card-create-user-account {
        margin-top: 60px;
    }

</style>