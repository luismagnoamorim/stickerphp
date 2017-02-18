<?php

    $email = isset($email)? $email: "";

?>

<div class="container">
    
    <div class="row">
        <div id="card-create-user-account" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Detalhes do álbum</h4>
                <br>
            </div>
            <div class="card-block">

                <h2><?php echo $album['titulo']?></h2>
                <p><b>Editora: <?php echo $album['editora']?></b></p>
                
                
                <p><b>Quantidade Cromos:</b> <?php echo $album['quantidadeCromos']?></p>
                <p><b>Idioma:</b> <?php echo $album['idioma']?></p>
                
                
                <p><b>Data publicação:</b> <?php echo $album['dataPublicacao']?></p>
                <p><b>Formato:</b> <?php echo $album['formato']?></p>
                <p><b>Data inclusão:</b> <?php echo $album['dataInclusao']?></p>

                <form action="/add-stickerbook-collection/" method="post">
                    <?php if (isset($_SESSION['usuario'])) { 
                        $podeColecionar = true;
                    ?>
                    <input type='hidden' id='usuario' name='usuarioId' value='<?php echo $_SESSION['usuario']['id']?>'>
                    <input type='hidden' id='colecao' name='colecaoId' value='<?php echo $colecao['id']?>'>

                    <?php } 
                        else {
                            $podeColecionar = false;
                        }
                    ?>
                    <input type='hidden' id='album' name='albumId' value='<?php echo $album['id'] ?>'>

                    <button type="submit" class="btn btn-default">Colecionar</button>
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