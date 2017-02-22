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
                
                
                <p><b>Quantidade Cromos:</b> <?php echo $album['quantidadeCromo']?></p>
                <?php
                    $progresso = (( sizeof($userStickers) * 100 ) / $album['quantidadeCromo']) ;
                ?>
                <p><b>Porcentagem completo:</b> <?= $progresso?></p>

                <p><b>Idioma:</b> <?php echo $album['idioma']?></p>
                
                <p><b>Data publicação:</b> <?php echo $album['anoPublicacao']?></p>
                
                <p><b>Data inclusão:</b> <?php echo $album['dataInclusao']?></p>


                <form action="/add-stickerbook-to-collection/" method="post">
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

                    <button type="submit" class="btn btn-default" id="btnIncluir">Incluir da coleção</button>
                    <button type="submit" class="btn btn-default" id="btnRetirar">Retirar da coleção</button>
                </form>
            </div>
        </div> 


        <div class="col-sm-12">
                <form class="form-horizontal" method="post" action="/updateCollection/">
                    <div class="row">

                        <?php
                            $i = 0;
                            foreach ($stickers as $sticker) {
                        ?> 
                                <div class="input-group col-sm-2">
                                    <button id="#btn_remove_<?php echo $sticker['id'] ?>" type="button" class="btn-xs"><i class="fa fa-minus" ></i></button>
                                    <input type="text" class="form-control" id="cromo_<?=$sticker['id']?>_<?=$album['id']?>" placeholder="Cod" value="<?=$sticker['codigo']?>" name="sticker[]">
                                    <?php
                                    	$quantidade = 0;
                                    	foreach ($userStickers as $userSticker) {
                                    		if($sticker['id'] == $userSticker['cromo_id']){
                                				$quantidade = $userSticker['quantidade'];
                                				break;
                                    		}
                                    	}
                                    ?>
                                    <input type="text" class="form-control" id="quantidade_<?=$sticker['id']?>_<?=$album['id']?>" value="<?=$quantidade?>" name="sticker[]">


									<button id="#btn_add_<?php echo $sticker['id'] ?>" type="button" class="btn-xs"><i class="fa fa-plus"  ></i></button>

                                    <!-- ///////////////////////////// RECUPERAR IDENTIFICADOR DA COLECAO ////////////////////////////////--> 
									<input type='hidden' id='colecao' name='colecaoId' value='1'>
                                </div>
                        <?php
                            $i++;                      
                            }
                        ?>                   
                    </div>
                </form>
        </div>                   




    </div>

</div>

<style>

    #card-create-user-account {
        margin-top: 30px;
    }

</style>

<script>
    jQuery(document).ready(function () {
		$('.btn-xs').click(function(e) {
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