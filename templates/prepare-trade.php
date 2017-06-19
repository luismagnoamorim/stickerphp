<?php

    $email = isset($email)? $email: "";

    //$_SESSION['usuarioId']   = 1;

    //print_r($stickerIn);
    //print_r($stickerOut);
    //print_r($stickersRepeated);

?>

<div class="container">
    
    <div class="row">
        <div id="card-create-user-ac'count" class="col-sm-12 offset-sm-1 col-md-8 offset-md-2 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Seleção para negociar</h4>
                <br>
            </div   >
        </div> 
    </div>
    <div class="row" >
    <?php
    if (isset($stickersIn)){
    ?>
        <div class="col-md-6">
            <div>
                <p class="bg-info"> A receber </p>
            </div>
            <div class="main">
                <?php
                    $i = 0;
                    foreach ($stickersIn as $stickerIn) {
                ?> 
                    <div data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="" class="collection-item">
                        <div class="sticker-container" id="sticker-action<?= $stickerIn['id'] ?>">
                            <h1><?= $stickerIn['codigo']?></h1>
                        </div>
                    </div>
                <?php
                    $i++;                      
                    }
                ?>
            </div>
        </div>

    <?php
    }
    if (isset($stickersOut)){
    ?>
        <div class="col-md-6">
        <div>
            <p class="bg-success"> A entregar</p>
        </div>            
            <div class="main">
                <?php
                    $i = 0;
                    foreach ($stickersOut as $stickerOut) {
                ?> 
                    <div data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="" class="collection-item">
                        <div class="sticker-container" id="sticker-action<?= $stickerOut['id'] ?>">
                            <h1><?= $stickerOut['codigo']?></h1>
                        </div>
                    </div>
                <?php
                    $i++;                      
                    }
                ?>
            </div>
        </div>
      
    <?php
    }
    ?>
    </div>
    <?php
    if (isset($stickersRepeated)){
    ?>
    <div class="row">
        <div class="col-md-6">
        <div>
            <p class="bg-primary"> Incluir na troca</p>
        </div>            
            <div class="main">
                <?php
                    $i = 0;
                    foreach ($stickersRepeated as $stickerRepeated) {
                ?> 
                    <div data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="" class="collection-item">
                        <div class="sticker-container" id="sticker-action<?= $stickerRepeated['id'] ?>">
                            <h1><?= $stickerRepeated['codigo']?></h1>
                        </div>
                    </div>
                <?php
                    $i++;                      
                    }
                ?>
            </div>
        </div>
    </div>
      
    <?php
    }
    ?>            
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