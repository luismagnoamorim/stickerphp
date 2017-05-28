<?php
    $_SESSION['usuarioId']   = 1;
?>
<div class="container">

    <h2>Meus álbuns</h2>
    	<div class="row">
       		<form action="/collections/" method="post">
                <input type='hidden' id='usuario' name='usuarioId' value='<?php echo $_SESSION['usuarioId']?>'>
                <button type="submit" class="btn btn-default">Minhas coleções</button>
            </form>
        </div>
        <br>
        <div class="col-sm-12">
                <h2>Álbuns disponiveis</h2>
                <form class="form-horizontal" method="post" action="/updateCollection/">
                    <div class="row">

                        <?php
                            foreach ($stickerBooks as $stickerBook) {
                        ?> 
                                <div class="input-group col-sm-4">
                                	<div class="thumbnail">
                                    	<img src='/img/capas/<?=$stickerBook['nomeImagem']?>.jpg' style="width:50%">
                                    
                                		<div class='caption'>
                                			<a href='/detail-stickerbook/' id='a_<?=$stickerBook['id']?>' class='albumRef'><?= $stickerBook['titulo'] ?></a>
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
<script>
    jQuery(document).ready(function () {
		$('a.albumRef').click(function(e) {
			
        	event.preventDefault();
        	$albumId    = $(this).attr('id').split('_')[1];
        	$url 		= $(this).attr("href");	
        	$.ajax({
            	type: 'POST'
             	,url: $url
            	,dataType: 'html'
            	,data: { albumId: $albumId } 
            ,success: function(response){
                console.log(response);
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