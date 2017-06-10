<?php
    //$_SESSION['usuarioId']   = 1;
    //$email = isset($_SESSION["user"])? $email: "";
    //$idUsuario = isset($idUsuario)? $idUsuario: null;

?>
<div class="container">
    <div class="col-xs-12">
        <h2>Álbuns disponiveis</h2>
            <div class="card-deck-wrapper">
            <div class="card-deck">
            <?php
                foreach ($stickerBooks as $stickerBook) {
            ?> 
                
                  <div class="card">
                    <a href='/detail-stickerbook/<?=$stickerBook['id']?>/0' id='a_<?=$stickerBook['id']?>'>
                        <img class="card-img-top img-fluid" src='/img/capas/<?=$stickerBook['nomeImagem']?>.jpg' alt="Card image cap" style="width:50%">
                        
                    

                    <div class="card-block">
                      <h5 class="card-title"><?= $stickerBook['titulo'] ?></h5>
                      <p class="card-text"><?= $stickerBook['editora'] ?></p>
                      
                    </div>
                    

                    </a>
                    <div class="card-footer">
                        <a href='/collection/stickerbook/add/<?= $stickerBook['id'] ?>' class="btn btn-primary">Incluir na coleção</a> 
                    </div>
                  </div>
                







                    <!--<div class="input-group col-sm-4">
                    	<div class="thumbnail">
                            <a href='/detail-stickerbook/<?=$stickerBook['id']?>/0' id='a_<?=$stickerBook['id']?>'>
                            	<img src='/img/capas/<?=$stickerBook['nomeImagem']?>.jpg' style="width:50%">
                        		<div class='caption'>
                        			<?= $stickerBook['titulo'] ?>
                        		</div>
                            </a>
                    	</div>
                    </div>-->
            <?php
                }
            ?>                   
            </div>
            </div>
    </div>
</div>  

<style>
.card-deck {
    width: 100%;
}
.card-deck .card{
    width: initial;
}
</style>