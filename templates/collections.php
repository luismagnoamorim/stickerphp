<?php
    //collections PHP - exibe os albuns incluidos pelo usuario
    $email = isset($email)? $email: "";

?>



<div class="container-fluid">
    <h2>Minhas coleções</h2>
    <div class="row">
       
        <div class="col-sm-12">
                
                    <div class="row">

                        <?php
                            if(!empty($collections)){
                            	foreach ($collections as $collection) {

                                $progresso = 0;
                                $quantidadeColecao = 0;
                                $quantidadeRepetidas = 0;
                                if (!empty($collection->userStickers)){
                                    foreach ($collection->userStickers as $userSticker) {
                                        if($userSticker['quantidade'] > 0){
                                            $quantidadeColecao = $quantidadeColecao + 1;
                                            if($userSticker['quantidade'] > 1){
                                                $quantidadeRepetidas = $quantidadeRepetidas + ( $userSticker['quantidade'] - 1 );
                                            }
                                        }
                                    }
                                    $progresso = ($quantidadeColecao / $collection['album']['quantidadeCromo']) * 100;    
                                }
                        ?> 



                                <div class="col-md-6 col-sm-4 col-xs-6">
                                	<div class="stickerbook-wrapper">
                                    	<a href='/detail-stickerbook/<?=$collection['album_id']?>/<?=$collection['id']?>'>
                                            <div class="row">
                                                <!--<div class="col-md-7 col-sm-2 col-xs-6">
                                                    <img class="img-responsive" src='/img/capas/<?=$collection['album']['nomeImagem']?>.jpg' style="max-width:100px">
                                                </div>-->
                                        		<div class="col-md-10 col-sm-4 col-xs-6">
                                        			<h4><?= $collection['album']['titulo'] ?></h4>
                                                    <p>Tenho <?= $quantidadeColecao ?> de <?=$collection['album']['quantidadeCromo']?></p>
                                                    <p><?=$progresso?> % completo</p>
                                                    <p>Quantidade de repetidas <?= $quantidadeRepetidas ?></p>
                                        		</div>
                                            </div>
                                        </a>
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
                
        </div>
    </div>

</div>

<style>

.stickerbook-wrapper{
    border:1px solid #ddd;
    background-color: #2b62bc;
    width: 25rem;
    float: left;
    margin-bottom:3px;
}


.stickerbook-wrapper a {
    color: #FFFFFF;
}


</style>