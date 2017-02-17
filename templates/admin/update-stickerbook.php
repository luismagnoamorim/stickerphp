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
            </div>

        </div> 



        <div class="col-sm-12">
                <form class="form-horizontal" method="post" action="/admin/add-sticker-to-book/<?=$album['id']?>">
                    <div class="row">

                        <?php
                            $i = 0;
                            foreach ($stickers as $sticker) {
                            
                        ?> 
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" id="cromo_<?=$i?>" placeholder="Cod" value="<?=$sticker['codigo']?>">
                                </div>
                                
                        <?php
                            $i++;                      
                            }
                    
                        ?>                   
                    </div>
                    
                    <?php 
                        if ($i > 0){
                    ?>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Atualizar cromos</button>
                            </div>
                    <?php
                        }
                    ?>              
                </form>

                <button class="btn  btn-lg btn-block" data-toggle="collapse" data-target="#demo">+50</button>
                <div id="demo" class="collapse">
                    <form method="post" action="/admin/add-sticker-to-book/">
                        
                        <div class="row">
                        <?php
                            for ($i = 1 ; $i<= 50 ; $i++) {
                        ?> 
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" name="newSticker[]">
                                </div>                        
                        <?php
                            }
                        ?>                            
                        </div>
                        <div class="form-group">
                            <input type='hidden' id='albumId' name='albumId' value='<?=$album['id']?>'>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Adicionar</button>
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