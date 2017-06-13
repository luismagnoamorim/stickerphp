<?php
    //$_SESSION['usuarioId']   = 1;
    //$email = isset($_SESSION["user"])? $email: "";
    //$idUsuario = isset($idUsuario)? $idUsuario: null;

?>
<div class="container-fluid">

        <h2>Álbuns disponíveis</h2>
            <div class="row">
            <?php
                foreach ($stickerBooks as $stickerBook) {
            ?> 
                    <div class="col-sm-2">
                        <a href='/detail-stickerbook/<?=$stickerBook['id']?>/0' id='a_<?=$stickerBook['id']?>'>
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                        <img src='/img/capas/<?=$stickerBook['nomeImagem']?>.jpg' alt="">
                                        <h2><?= $stickerBook['titulo'] ?></h2>
                                        <p><?= $stickerBook['editora'] ?></p>
                                        <a href="/collection/stickerbook/add/<?= $stickerBook['id'] ?>" class="btn btn-primary btn-block"></i>Incluir na coleção</a>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>                
                  

                  <!--<div class="card">
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
                







                    <div class="input-group col-sm-4">
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

<style>


.productinfo h2{
    /*color: #FE980F;*/
    font-family: 'Roboto', sans-serif;
    font-size: 18px;
    
}
.product-overlay h2{
    color: #fff;
    font-family: 'Roboto', sans-serif;
    font-size: 18px;
    
}


.productinfo p{
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
  color: #696763;
}

.productinfo img{
  width: 100%;
}

.productinfo{
 position:relative;
}

.product-image-wrapper{
    border:1px solid #ddd;
    
    overflow: hidden;
    margin-bottom:30px;
}

.single-products {
  position: relative;
}
</style>