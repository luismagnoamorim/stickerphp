<?php

    $email = isset($email)? $email: "";

?>

<div class="container">
    
    <div class="row">
        <div id="card-create-user-account" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Atualizar álbum</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite as informações do álbum.</h6>
            </div>
            <div class="card-block">
                <form method="post" action="/admin/update-stickerbook/<?=$album['id']?>">
                    <div class="form-group <?=isset($errors["email"])? "has-danger": "" ?>">
                        <input id="titulo" class="form-control form-control-lg <?=isset($errors["titulo"])? "form-control-danger": "" ?>"
                            name="titulo" type="text" placeholder="Título do álbum" value="<?=$album['titulo'] ?>">
                        <input id="editora" class="form-control form-control-lg <?=isset($errors["editora"])? "form-control-danger": "" ?>"
                            name="editora" type="text" placeholder="Editora" value="<?=$album['editora'] ?>">
                        <input id="anoPublicacao" class="form-control form-control-lg <?=isset($errors["anoPublicacao"])? "form-control-danger": "" ?>"
                            name="anoPublicacao" type="text" placeholder="Ano de publicação" value="<?=$album['anoPublicacao'] ?>">
                        <input id="idioma" class="form-control form-control-lg <?=isset($errors["idioma"])? "form-control-danger": "" ?>"
                            name="idioma" type="text" placeholder="Idioma" value="<?=$album['idioma'] ?>">                            
                        <input id="quantidadeCromo" class="form-control form-control-lg <?=isset($errors["quantidadeCromo"])? "form-control-danger": "" ?>"
                            name="quantidadeCromo" type="text" placeholder="Quantidade total de cromos" value="<?=$album['quantidadeCromo'] ?>">
                        <input type='hidden' id='albumId' name='albumId' value='<?=$album['id']?>'>    
                        <?php if (isset($errors["titulo"])) { ?>
                            <div class="form-control-feedback"><?=$errors["titulo"] ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Salvar</button>
                    </div>
                </form> 
                <form method="post" action="/admin/add-sticker-to-book/<?=$album['id']?>">
                    <input type='hidden' id='albumId' name='albumId' value='<?=$album['id']?>'> 
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><?=count($stickers)?>+50</button>
                    </div>                
                </form>
            </div>
        </div> 

        <form method="post" action="/admin/add-sticker-to-book/<?=$album['id']?>">
            <div class="row">
            <?php 

                if ($stickers) :
            ?>
             
            
            <?php
                        $i = 0;
                        foreach ($stickers as $sticker) {
                            $i = $i + 1;
                        if ($i%5)
            ?>
                            
                              <div class="col-sm-2">
                                <div class="input-group">
                                  <span class="input-group-addon" id="btnGroupAddon"><?=$sticker['id']?></span>
                                  <input type="text" class="form-control" placeholder="Código" value="<?=$sticker['codigo']?>">
                                  <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                    
                                  </span>
                                </div>
                              </div>
                            
                              
            <?php                      
                        }
                endif;
            ?>
            </div>    
        </form>


    </div>



</div>

<style>

    #card-create-user-account {
        margin-top: 60px;
    }

</style>