<?php

    $email = isset($email)? $email: "";

?>

<div class="container">
    
    <div class="row">
       
        <div class="col-sm-12">
                <form class="form-horizontal" method="post" action="/updateCollection/">
                    <div class="row">

                        <?php
                            foreach ($collections as $collection) {
                            	//print_r($collection);
                        ?> 
                                <div class="input-group col-sm-4">
                                	<div class="thumbnail">
                                    	<img src='/img/capas/<?=$collection['album_id']?>.jpg' style="width:50%">
                                    
                                		<div class='caption'>
                                			<a href='/detail-stickerbook/<?=$collection['album_id']?>/<?=$collection['id'] ?>'><?= $collection['album']['titulo'] ?></a>
                                		</div>
                                	</div>
                                </div>
                        <?php
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