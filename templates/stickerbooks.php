<?php
    //$_SESSION['usuarioId']   = 1;
    //$email = isset($_SESSION["user"])? $email: "";
    //$idUsuario = isset($idUsuario)? $idUsuario: null;

?>
<div class="container">

    <h2>Meus álbuns</h2>
    	<div class="row">
            <a class="btn btn-primary btn-lg" href="/collections" role="button">Minha coleção</a>
        </div>
        <br>
        <div class="col-sm-12">
            <h2>Álbuns disponiveis</h2>
            <div class="row">
                <?php
                    foreach ($stickerBooks as $stickerBook) {
                ?> 
                        <div class="input-group col-sm-4">
                        	<div class="thumbnail">
                            	<img src='/img/capas/<?=$stickerBook['nomeImagem']?>.jpg' style="width:50%">
                            
                        		<div class='caption'>
                        			<a href='/detail-stickerbook/<?=$stickerBook['id']?>/0' id='a_<?=$stickerBook['id']?>' class='albumRefaaaa'><?= $stickerBook['titulo'] ?></a>
                        		</div>
                        	</div>
                        </div>
                <?php
                    }
                ?>                   
            </div>
        </div>
</div>  