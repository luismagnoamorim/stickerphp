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
            

            <div class="col-sm-2">
                <div class="sticker-box">
                    <h1>box</h1>
                    <div class="sticker-info">
                        <h1>Info</h1>
                    </div>
                </div>
            </div>

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

    <?php
      if (isset($userStickers)){
    ?>
        <div class="col-sm-12">
                <form class="form-horizontal" method="post" action="/updateCollection/">
                    <div class="row">

                        <?php
                            $i = 0;
                            foreach ($stickers as $sticker) {
                        ?> 
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
                                        <!--
                                        <button id="#btn_remove_<?= $sticker['id'] ?>" type="button" class="btn-xs"><i class="fa fa-minus" ></i></button>
                                        <button id="#btn_add_<?= $sticker['id'] ?>" type="button" class="btn-xs"><i class="fa fa-plus"  ></i></button> -->
                                        <input type='hidden' id='colecao' name='colecaoId' value='1'>
                                    </div>
                                    <div class="sticker-actions-footer">
                                        <div class="sticker-action1">+</div>
                                        <div class="sticker-action2">-</div>
                                    </div>
                                    
                                  </div>
                     
                        <?php
                            $i++;                      
                            }
                        ?>                   
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

    .rect{  
      margin:0 0 2px;
      padding: 2px;
      border:0px solid #333;
      width: 100%;
      text-align:center;
      color: #000000;
    }
    .header{
       margin:0 auto;
       padding: 5px 10px;
       width:100%;
       border:2px solid #333;
    }
    .sticker-box{
      margin: 5px 0;
      border:1px solid blue;
      border-radius: 2px;
      background: rgba(51, 153, 255, 1);
      text-align:center;
      color: #FFFFFF;
    }

    .sticker-info{
        width: 100%;
        height: 60%;
        color: 2px solid red;

    }
    .sticker-container .sticker-actions-footer {
      border-top: 1px solid #CCCCCC;
      bottom: 0;
      position: absolute;
      width: 100%;
      visibility: hidden;
      opacity: 0;
      filter: alpha(opacity=0);
      -webkit-transition-property: opacity;
      transition-property: opacity;
      -webkit-transition-duration: 0.2s;
      transition-duration: 0.2s;
    }
    .sticker-container .sticker-action1,
    .sticker-container .sticker-action2 {
      cursor: pointer;
      width: 50%;
      float: left;
      text-align: center;
    }
    .sticker-container .sticker-action1:hover,
    .sticker-container .sticker-action2:hover {
      background: #e44c4c;
    }
    .sticker-container .sticker-action1 {
      border-right: 1px solid #ccc;
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