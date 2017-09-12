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
                        $quantidadeFaltantes = 0;
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
                            $quantidadeFaltantes = $collection['album']['quantidadeCromo'] - $quantidadeColecao;
                        }
                ?> 
                        <div class="col-md-6 col-sm-10 col-xs-6">
                        	<div class="stickerbook-wrapper">
                            	<a href='/detail-stickerbook/<?=$collection['album_id']?>/<?=$collection['id']?>'>
                                        <!--<div class="col-sm-2 col-sm-2 col-xs-2">
                                            <img class="img-responsive" src='/img/capas/<?=$collection['album']['nomeImagem']?>.jpg' style='max-height:220px'>
                                        </div>-->
                                		<div class="col-sm-12 col-sm-10 col-xs-10">
                                			<h5 style="text-align:center"><?= $collection['album']['titulo'] ?></h5>
                                            <p> <i class="fa fa-thumbs-o-up fa-lg"></i> Tenho <?= $quantidadeColecao ?> de <?=$collection['album']['quantidadeCromo']?></p>
                                            <p> <i class="fa fa-thumbs-o-down fa-lg"></i> Faltam <?=$quantidadeFaltantes?></p>
                                            <p> <i class="fa fa-line-chart fa-lg"></i> <?=number_format($progresso,1)?> % completo</p>
                                            <p> <i class="fa fa-clone fa-lg"></i> Quantidade de repetidas: <?= $quantidadeRepetidas ?></p>
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
            <div class="row">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- StickerTrade -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:320px;height:100px"
                     data-ad-client="ca-pub-2494591908945933"
                     data-ad-slot="6689319364"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>            
            </div>
        </div>
    </div>
</div>

<style>

.stickerbook-wrapper{
    border:1px solid #ddd;
    background-color: #2b62bc;
    width: 20rem;
    float: left;
    margin-bottom:3px;
}


.stickerbook-wrapper a {
    color: #FFFFFF;
}

.stickerbook-wrapper p {
    margin: 0;
}


</style>

