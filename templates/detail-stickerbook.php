<?php

    $email = isset($email)? $email: "";

    $progresso = 0;
    $quantidadeColecao = 0;
    $quantidadeRepetidas = 0;
    $quantidadeFaltantes = 0;
    if (!empty($userStickers)){
        foreach ($userStickers as $userSticker) {
            if($userSticker['quantidade'] > 0){
                $quantidadeColecao = $quantidadeColecao + 1;
                if($userSticker['quantidade'] > 1){
                    $quantidadeRepetidas = $quantidadeRepetidas + ( $userSticker['quantidade'] - 1 );
                }
            }
        }
        $progresso = ($quantidadeColecao / $album['quantidadeCromo']) * 100;    
        $quantidadeFaltantes = $album['quantidadeCromo'] - $quantidadeColecao;
    }
?>




<div class="container-fluid">
    <div class="col-md-8" style="padding-left:0">
        <div class="card mb-1">
          <h3 class="card-header"><?= $album['titulo']?> - <?=number_format($progresso,1)?>%</h3>
          <div class="card-block">
            <h4 class="card-title">Editora: <?= $album['editora']?></h4>
            <div class="row">
                <div class="col-sm-8">
                    <p class="card-text">Tenho <?=$quantidadeColecao?> de <?= $album['quantidadeCromo']?> </p>
                    <p class="card-text">Faltam <?= $quantidadeFaltantes?> </p>
                    <p class="card-text">Data inclusão:</b> <?php echo $album['dataInclusao']?></p>
                    <?php
                    //usuario possui colecao - area de atualizacao da colecao
                    if ($colecaoId != 0 and isset($userStickers)){
                    ?>
                        <a href='/trade/findtrader/<?= $colecaoId ?>'>
                          <button class="btn btn-primary">Trocar Figurinhas</button>
                        </a>
                        <a href='/collection/stickerbook/remove/<?= $colecaoId ?>'>
                          <button class="btn btn-danger">Retirar da coleção</button>
                        </a>                        
                    <?php 
                    } else {
                    ?>
                        <a href='/collection/stickerbook/add/<?= $album['id'] ?>'>
                            <button class="btn btn-success">Incluir na coleção</button>
                        </a>
                    <?php 
                    } 
                    ?>                        
                </div>
                <!--<div class="col-sm-4">
                    <img src='/img/capas/<?=$album['nomeImagem']?>.jpg' style="max-width:80%">
                </div>-->
            </div>
          </div>
        </div>
    </div> 
    
    <?php
    if (isset($stickers) and $colecaoId != 0){
    ?>
    <div class="card">
        <h4 class="card-header">Figurinhas</h4> 
            
      
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
    <?php
    }
    ?>        
    </div>    
</div>
<style>
    .collection-item{
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

    a#scrollUp {
      bottom: 0px;
      right: 10px;
      padding: 5px 10px;
      background: #4286f4;
      color: #FFF;
      -webkit-animation: bounce 2s ease infinite;
      animation: bounce 2s ease infinite;
    }

    a#scrollUp i{
      font-size: 30px;
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
        };


        $(function () {
            $.scrollUp({
                scrollName: 'scrollUp', // Element ID
                scrollDistance: 300, // Distance from top/bottom before showing element (px)
                scrollFrom: 'top', // 'top' or 'bottom'
                scrollSpeed: 300, // Speed back to top (ms)
                easingType: 'linear', // Scroll to top easing (see http://easings.net/)
                animation: 'fade', // Fade, slide, none
                animationSpeed: 200, // Animation in speed (ms)
                scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
                        //scrollTarget: false, // Set a custom target element for scrolling to the top
                scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
                scrollTitle: false, // Set a custom <a> title if required.
                scrollImg: false, // Set true to use image
                activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
                zIndex: 2147483647 // Z-Index for the overlay
            });
        });






    });//jQuery
</script>    
<script src="/js/jquery.scrollUp.min.js"></script>