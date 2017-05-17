<?php

    $email = isset($email)? $email: "";

    $_SESSION['usuarioId']   = 1;

?>

<div class="container">
    
    <div class="row">
        <div id="card-create-user-ac'count" class="col-sm-12 offset-sm-1 col-md-8 offset-md-2 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Detalhes do álbum</h4>
                <br>
            </div   >
            

            <div class="col-sm-6">
                <h2><?= $album['titulo']?></h2>
                <p><b>Editora: <?= $album['editora']?></b></p>
                
                <p><b>Quantidade Cromos:</b> <?= $album['quantidadeCromo']?></p>
                <?php
                    $progresso;
                    $quantidadeColecao = 0;
                    if (isset($userStickers)){
                        foreach ($userStickers as $userSticker) {
                            if($userSticker['quantidade'] > 0){
                                $quantidadeColecao = $quantidadeColecao + 1;
                            }
                        }
                        $progresso = ($quantidadeColecao / $album['quantidadeCromo']) * 100;    
                ?>
                    <p><b>Tenho </b> <?=$quantidadeColecao?> de <?= $album['quantidadeCromo']?></p>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=number_format($progresso,1) ?>"
                      aria-valuemin="0" aria-valuemax="100" style="width:<?=$progresso?>%">
                        <?=number_format($progresso,0)?>%
                      </div>
                    </div>                
                <?php
                    } 
                ?>

                <p><b>Idioma:</b> <?php echo $album['idioma']?></p>
                
                <p><b>Data publicação:</b> <?php echo $album['anoPublicacao']?></p>
                
                <p><b>Data inclusão:</b> <?php echo $album['dataInclusao']?></p>
            </div>
            
            <div class="col-sm-6">
                <img src='/img/capas/<?=$album['id']?>.jpg' style="width:50%">
            </div>

            <div class="col-sm-12">
                <?php
                if (isset($userStickers)){
                ?>
                    <form action="/collection/stickerbook/remove/" method="post">
                        <input type='hidden' id='usuario' name='usuarioId' value='<?= $_SESSION['usuarioId']?>'>
                        <input type='hidden' id='colecao' name='colecaoId' value='<?= $colecaoId?>'>

                        <button type="submit" class="btn btn-default">Retirar da coleção</button>
                    </form>
                <?php 
                } else {
                ?>
                    <form action="/collection/stickerbook/add/" method="post">
                        <?php 
                            if (isset($_SESSION['usuario'])) { 
                        ?>
                        <input type='hidden' id='usuario' name='usuarioId' value='<?php echo $_SESSION['usuario']['id']?>'>
                        <input type='hidden' id='colecao' name='colecaoId' value='<?php echo $colecao['id']?>'>

                        <?php 
                            }
                        ?>
                        <input type='hidden' id='album' name='albumId' value='<?php echo $album['id'] ?>'>

                        
                        <?php
                            if (isset($userStickers)){
                        ?>
                              <button type="submit" class="btn btn-default" id="btnRetirar">Retirar da coleção</button>
                              /collection/stickerbook/remove/
                        <?php
                            }else{
                        ?>
                              <button type="submit" class="btn btn-default" id="btnIncluir">Incluir na coleção</button>  
                        <?php
                            }
                        ?>
                    </form>
                <?php 
                } 
                ?>
            </div>
        </div> 
    </div>
    <?php
      if (isset($userStickers)){
    ?>
    <div class="row" >
        <div class="col-xs-12">
                <form class="form-horizontal" method="post" action="/updateCollection/">
                   
                        <div class="main">
                            <ul id="rb-grid" class="rb-grid clearfix">
                            <?php
                                $i = 0;
                                foreach ($stickers as $sticker) {
                            ?> 
                                <li>
                                    <div class="rb-info">
                                        <h3><?= $sticker['codigo']?></h3>
                                        <?php
                                            $quantidade = 0;
                                            if(isset($userStickers)){
                                                foreach ($userStickers as $userSticker) {
                                                    if($sticker['id'] == $userSticker['cromo_id']){
                                                        $quantidade = $userSticker['quantidade'];
                                                        break;
                                                    }
                                                }
                                            }
                                        ?>
                                        <span class="rb-qtd">Qt <?=$quantidade?></span>    
                                    </div>
                                    <div class="rb-week">
                                        <div><span>-1</span></div>
                                        <div><span>+1</span></div>
                                    </div>
                                </li>
                            
                                
                                        <!--                    
                            
                                  <div class="col-xs-4 sticker-box">
                                    <div class="sticker-info">
                                        <i class="fa fa-tag" aria-hidden="true"><?= $sticker['codigo']?></i>
                                        <?php
                                            $quantidade = 0;
                                            if(isset($userStickers)){
                                                foreach ($userStickers as $userSticker) {
                                                    if($sticker['id'] == $userSticker['cromo_id']){
                                                        $quantidade = $userSticker['quantidade'];
                                                        break;
                                                    }
                                                }
                                            }
                                        ?>
                                        <p>Qt <?=$quantidade?></p>
                            
                                        <button id="#btn_remove_<?= $sticker['id'] ?>" type="button" class="btn-xs"><i class="fa fa-minus" ></i></button>
                                        <button id="#btn_add_<?= $sticker['id'] ?>" type="button" class="btn-xs"><i class="fa fa-plus"  ></i></button> 
                                        <input type='hidden' id='colecao' name='colecaoId' value='1'>
                                    </div>
                                    <div class="sticker-actions-footer">
                                        <div class="sticker-action1">+</div>
                                        <div class="sticker-action2">-</div>
                                    </div>
                                    
                                  </div>
                                  -->
                     
                        <?php
                            $i++;                      
                            }
                        ?>
                            </ul>               
                        </div>                   
                   
                </form>
        </div>
    <?php
      }
    ?>        




    </div>

</div>

<style>
    #card-create-user-account {
        margin-top: 30px;
    }
</style>

<script>
    jQuery(document).ready(function () {
		$('.btn-xs').on('click touchstart' , function(e) {
        	$colecaoId	= $("#colecao").attr('value');
        	$acao 		= $(this).attr('id').split('_')[1];
        	$cromoId	= $(this).attr('id').split('_')[2];
        	$url 		= "/updateCollection";
        	//alert($colecaoId + ' ' + $acao + ' ' + $cromoId );
        	$.ajax({
            	type: 'POST'
             	,url: $url
            	,dataType: 'html'
            	,data: { colecaoId: $colecaoId , cromoId: $cromoId , acao: $acao } 
            //,success: function(html){
   			// 	$("#results").append(html);
   			//        alert('textGoogleKey' + textGoogleKey);
  			//}
            ///,error: function(jqXHR, textStatus) {
                //console.error("error");
                    //alert('Not working!' + textStatus);
            ///}
            });	//$.ajax
        });//btn.click
        
    });//jQuery
</script>    