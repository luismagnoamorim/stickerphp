<?php

    $email = isset($email)? $email: "";

?>

<div class="container">
    
    <div class="row">
       
        <div class="col-sm-12">
                <form class="form-horizontal" method="post" action="/updateCollection/">
                    <div class="row">

                        <?php
                        	if(isset($collections)){
                            	foreach ($collections as $collection) {
                            	//print_r($collection);
                        ?> 
                                <div class="input-group col-sm-4">
                                	<div class="thumbnail">
                                    	<img src='/img/capas/<?=$collection['album_id']?>.jpg' style="width:50%">
                                    
                                		<div class='caption'>
                                			<a href='/detail-stickerbook/' id='a_<?=$collection['album_id']?>_<?=$collection['id']?>' class='albumRef'><?= $collection['album']['titulo'] ?></a>
                                		</div>
                                	</div>
                                </div>
                        <?php
                            	}
                        	}else {
                       	?>
                       			<div id="jumbotron" class="jumbotron">
                       			<h1 class="display-5">Coleção vazia</h1>
                       			<p>Selecione os álbuns que deseja colecionar e boa diversão	.</p>
                        		<a class="btn btn-primary btn-lg" href="/stickerbooks" role="button">Iniciar coleção</a>
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
		$('a.albumRef').click(function(e) {
			
        	event.preventDefault();
        	$albumId    = $(this).attr('id').split('_')[1];
        	$colecaoId	= $(this).attr('id').split('_')[2];
        	$url 		= $(this).attr("href");	
        	//alert($colecaoId + ' ' + $acao + ' ' + $cromoId );
        	$.ajax({
            	type: 'POST'
             	,url: $url
            	,dataType: 'html'
            	,data: { albumId: $albumId , colecaoId: $colecaoId} 
            ,success: function(response){
   			 	$("body").html(response);
   			
  			}
            ///,error: function(jqXHR, textStatus) {
                //console.error("error");
                    //alert('Not working!' + textStatus);
            ///}
            });	//$.ajax
        });//href.click
        
    });//jQuery
</script>    