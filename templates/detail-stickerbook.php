<?php

    $email = isset($email)? $email: "";

    //$_SESSION['usuarioId']   = 1;

    //print_r($album);

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
                    if (!empty($userStickers)){
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
                <img src='/img/capas/<?=$album['nomeImagem']?>.jpg' style="width:50%">
            </div>

            <div class="col-sm-12">
                <?php
                //usuario possui colecao - area de atualizacao da colecao
                if ($colecaoId != 0 and isset($userStickers)){
                ?>
                    <a href='/collection/stickerbook/remove/<?= $colecaoId ?>'>
                      <button class="btn btn-default">Retirar da coleção</button>
                    </a>
                <?php 
                } else {
                ?>
                    <a href='/collection/stickerbook/add/<?= $album['id'] ?>'>
                        <button class="btn btn-default">Incluir na coleção</button>
                    </a>
                <?php 
                } 
                ?>
            </div>
        </div> 
    </div>
    <?php
    if (isset($stickers) and $colecaoId != 0){
    ?>
        <div class="row" >
            <div class="col-md-12">
                    <form class="form-horizontal" method="post" action="/updateCollection/">
                            <div class="main">
                                <?php
                                    $i = 0;
                                    foreach ($stickers as $sticker) {
                                ?> 
                                    <div data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="" class="collection-item">
                                        <div class="sticker-container" id="sticker-action<?= $sticker['id'] ?>">
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
                                            <h1><?= $sticker['codigo']?></h1>
                                            <div class="sticker-actions-footer">
                                                <div class="sticker-action1" id="<?= $sticker['id'] ?>"><i class="fa fa-minus-square fa-lg"></i></div>
                                                <div class="sticker-no-action"><?= $quantidade ?></div>
                                                <div class="sticker-action2" id="<?= $sticker['id'] ?>"><i class="fa fa-plus-square fa-lg"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $i++;                      
                                    }
                                ?>
                                <input type="hidden" id="colecao" value="<?= $colecaoId ?>">
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

    .collection-item, .collection-item-uneditable {
        width: 78px;
        float: left;
        padding: 6px;
        font-size: 0.9em;
    }

.sticker-container {
    display: block;
    border: 1px solid;
    border-color: #dedede;
    background-color: #2D87B4;



    

    text-align: center;
    border-top-right-radius: 4px;
    border-top-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
    padding: 24px 0;
    cursor: pointer;
    min-height: 85px;
    position: relative;
    overflow: hidden;
    
}

.sticker-container h1 {
    font-size: 2em;
    color: white;
}

.sticker-container h2 {
    font-size: 1.2em;
    color: black;
}

.sticker-container .sticker-actions-footer {
    border-top: 1px solid #CCCCCC;
    bottom: 0;
    position: absolute;
    width: 100%;   
    float: left;
    color: black;
    background: #3399CC;
}

.sticker-container .sticker-action1, .sticker-container .sticker-action2 , .sticker-container .sticker-no-action {
    cursor: pointer;
    width: 33%;
    float: left;
    text-align: center;
}     

.sticker-container .sticker-action1:hover, .sticker-container .sticker-action2:hover {
    background: #143D52;
}

</style>

<script>
    jQuery(document).ready(function () {
		$('.sticker-action1').on('click' , function(e) {
        	$colecaoId	= $("#colecao").attr('value');
        	$acao 		= 'remove';
        	$cromoId	= $(this).attr('id');
        	$url 		= "/updateCollection";
        	//alert($colecaoId + ' ' + $acao + ' ' + $cromoId );
        	$.ajax({
            	type: 'POST'
             	,url: $url
            	,dataType: 'html'
            	,data: { colecaoId: $colecaoId , cromoId: $cromoId , acao: $acao } 
            ,success: function(quantidade){
                var $quantidadeAtual =  0;
                $quantidadeAtual = Number($('#sticker-action'+$cromoId+ ' .sticker-no-action').text()) - 1;
                if ($quantidadeAtual < 0){
                    $quantidadeAtual = 0;
                }
                //$('#sticker-action'+$cromoId+ ' .sticker-no-action').remove();
                $('#sticker-action'+$cromoId+ ' .sticker-no-action').html($quantidadeAtual);
                aplicaCorPorQuantidade($('#sticker-action'+$cromoId) , $quantidadeAtual);

  			}
            ///,error: function(jqXHR, textStatus) {
                //console.error("error");
                    //alert('Not working!' + textStatus);
            ///}
            });	//$.ajax
        });//sticker-action1 remove

        $('.sticker-action2').on('click' , function(e) {
            $colecaoId  = $("#colecao").attr('value');
            $acao       = 'add';
            $cromoId    = $(this).attr('id');
            $url        = "/updateCollection";
            //alert($colecaoId + ' ' + $acao + ' ' + $cromoId );
            $.ajax({
                type: 'POST'
                ,url: $url
                ,dataType: 'html'
                ,data: { colecaoId: $colecaoId , cromoId: $cromoId , acao: $acao } 
            ,success: function(quantidade){
                var $quantidadeAtual =  0;
                $quantidadeAtual = Number($('#sticker-action'+$cromoId+ ' .sticker-no-action').text()) + 1;
                if ($quantidadeAtual < 0){
                    $quantidadeAtual = 0;
                }
                //$('#sticker-action'+$cromoId+ ' .sticker-no-action').remove();
                $('#sticker-action'+$cromoId+ ' .sticker-no-action').html($quantidadeAtual);
                aplicaCorPorQuantidade($('#sticker-action'+$cromoId) , $quantidadeAtual);

            }
            ///,error: function(jqXHR, textStatus) {
                //console.error("error");
                    //alert('Not working!' + textStatus);
            ///}
            }); //$.ajax
        });//btn.click        

        $('.sticker-container').each( function(e){
            var $quantidadeStickerCollection = $(this).find('div.sticker-no-action').text();
            aplicaCorPorQuantidade($(this), $quantidadeStickerCollection);
            //if( quantidadeStickerCollection == 0 ){
            //    $(this).css('background-color','#DD4D2C');
            //} else if (quantidadeStickerCollection == 1) {
            //    $(this).css('background-color','#339966');
            //} else {
            //    $(this).css('background-color','#2D87B4');
            //};
        });

        function aplicaCorPorQuantidade($element , $quantidade){
            if( $quantidade == 0 ){
                $element.css('background-color','#DD4D2C');
            } else if ($quantidade == 1) {
                $element.css('background-color','#339966');
            } else {
                $element.css('background-color','#2D87B4');
            }; 
        }
    });//jQuery
</script>    