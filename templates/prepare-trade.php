<?php

    $email = isset($email)? $email: "";

    //$_SESSION['usuarioId']   = 1;

    //print_r($stickersIn);
    //print_r($collectionIn);
    //print_r($collectionOut);
    //print_r($stickerOut);



    //print_r($stickersRepeated);

?>

<div class="container">
    <input type="hidden" id="colecaoEntrada" value="<?= $collectionIn ?>">
    <div class="row">
        <div class="card">
            <h3 class="card-header">Negociar troca</h3>
                <div class="card-block">
                    
                    <p class="card-text">Selecione as figurinhas que faltam na sua coleção e as suas repetidas que serão trocadas e confirme para atualizar a sua coleção.</p>
                    <a href="#" class="btn btn-primary" id="btn-inclui-troca">Confirma troca</a>
                </div>
        </div>
    </div>

    <div class="row" >
    <?php
    if (isset($stickersIn)){
    ?>
        <div class="col-md-6">
            <div>
                <p class="bg-info"> Não tenho</p>
            </div>
            <div class="main">
                <?php
                    $i = 0;
                    foreach ($stickersIn as $stickerIn) {
                ?> 
                        <div data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="" class="searchable-container">
                                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                                    <label class="btn btn-default">
                                        <div class="bizcontent">
                                            <input class="inCheckbox" type="checkbox" name="var_id[]" autocomplete="off" value="<?= $stickerIn['colecao']?> <?= $stickerIn['id']?>">
                                            <h1><?= $stickerIn['codigo']?></h1>
                                            <span class="fa fa-check fa-lg"></span>
                                        </div>
                                    </label>
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
            <p class="bg-success"> Minhas repetidas</p>
        </div>            
            <div class="main">
                <?php
                    $i = 0;
                    foreach ($stickersOut as $stickerOut) {
                ?> 
                        <div data-toggle="tooltip" data-container="body" data-placement="top" title="" data-original-title="" class="searchable-container">
                                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                                    <label class="btn btn-default">
                                        <div class="bizcontent">
                                            <input class="outCheckbox" type="checkbox" name="var_id[]" autocomplete="off" value="<?= $stickerOut['id']?>">
                                            <h1><?= $stickerOut['codigo']?></h1>
                                            <span class="fa fa-check fa-lg"></span>
                                        </div>
                                    </label>
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
    <!--
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
    ?>-->            
</div>


<style>
    .searchable-container{        
        width: 78px;
        float: left;
        padding: 6px;
        font-size: 0.9em;
    }
    .searchable-container label.btn-default.active{background-color:#007ba7;color:#FFF}
    .searchable-container label.btn-default{width:100%;border:2px solid #dedede;padding: 24px 0;
    }
    .searchable-container label .bizcontent{
        width: 100%;
    }
    .searchable-container .btn-group {
        width: 100%;
    }
    .searchable-container .btn span.fa{
        opacity: 0;
    }
    .searchable-container .btn.active span.fa {
        opacity: 1;
    }

    .searchable-container h1 {
        font-size: 2em;
        /*color: black;*/
    }

    .searchable-container h2 {
        font-size: 1.2em;
        /*color: black;*/
    }


</style>

<script>
    jQuery(document).ready(function () {
        $(function() {
            $('#search').on('keyup', function() {
                var pattern = $(this).val();
                $('.searchable-container .items').hide();
                $('.searchable-container .items').filter(function() {
                    return $(this).text().match(new RegExp(pattern, 'i'));
                }).show();
            });
        });
                

        $('#btn-inclui-troca').on('click' , function(e) {
            var $arrEntrada = [];
            var $arrSaida   = [];
            $('.inCheckbox').each( function(e){
                if ($(this).is(':checked')){
                    $arrEntrada = $arrEntrada.concat($(this).val());
                }
            });

            $('.outCheckbox').each( function(e){
                if ($(this).is(':checked')){
                    $arrSaida = $arrSaida.concat($(this).val());
                }
            });
            $colecaoId = $("#colecaoEntrada").attr('value');
            
            //alert( 'Colecao A:' + $colecaoId  + 'Entrada:' + $arrEntrada+ 'Saida:' + $arrSaida);
            
            
            $url    = "/trade/negotiate/save/";
            $.ajax({
                type: 'POST'
                ,url: $url
                ,dataType: 'html'
                ,data: { colecaoId: $colecaoId , arrEntrada: $arrEntrada , arrSaida: $arrSaida } 
            ,success: function(quantidade){
                //alert("gravado");
            //    var $quantidadeAtual =  0;
            //    $quantidadeAtual = Number($('#sticker-action'+$cromoId+ ' .sticker-no-action').text()) + 1;
            //    if ($quantidadeAtual < 0){
            //        $quantidadeAtual = 0;
            //    }
                //$('#sticker-action'+$cromoId+ ' .sticker-no-action').remove();
            //    $('#sticker-action'+$cromoId+ ' .sticker-no-action').html($quantidadeAtual);
                //aplicaCorPorQuantidade($('#sticker-action'+$cromoId) , $quantidadeAtual);

            }
            ///,error: function(jqXHR, textStatus) {
                //console.error("error");
                    //alert('Not working!' + textStatus);
            ///}
            }); //$.ajax */
            
        });
    });//jQuery
</script>    