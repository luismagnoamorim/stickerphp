<?php
    //collections PHP - exibe os albuns incluidos pelo usuario
    $email = isset($email)? $email: "";
    //print_r($pendindTradesIn);
    //print_r($pendindTradesOut);
?>



<div class="container-fluid">
    <h2>Gerenciamento de trocas</h2>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div>
                <h5 style="text-align:center">Nome do album<?= $stickerbook['titulo'] ?></h5>
                </div>
                <?php
                    if(!empty($pendindTradesIn)){
                    	foreach ($pendindTradesIn as $pendindTradeIn) {
                ?> 
                        <div class="col-md-6 col-sm-10 col-xs-6">
                    		<div class="col-sm-12 col-sm-10 col-xs-10">
                                <p> <i class="fa fa-calendar fa-lg"></i> Data da inclusão: <?= $pendindTradeIn['dataInclusao'] ?> </p>
                                <p> <i class="fa fa-arrow-left fa-lg"></i> Quantidade recebida: <?= $pendindTradeIn['quantidadeCromoEntrada'] ?> </p>
                                <p> <i class="fa fa-arrow-right fa-lg"></i> Quantidade entregue: <?= $pendindTradeIn['quantidadeCromoSaida'] ?> </p>
                    		</div>
                        </div>
                <?php
                        }
                    }
                    if(!empty($pendindTradesOut)){
                        foreach ($pendindTradesOut as $pendindTradeOut) {
                ?>
                        <div class="col-md-6 col-sm-10 col-xs-6">
                            <div class="col-sm-12 col-sm-10 col-xs-10">
                                <p> <i class="fa fa-calendar fa-lg"></i> Data da inclusão: <?= $pendindTradeOut['dataInclusao'] ?> </p>
                                <p> <i class="fa fa-thumbs-o-up fa-lg"></i> Quantidade entregue: <?= $pendindTradeOut['quantidadeCromoEntrada'] ?> </p>
                                <p> <i class="fa fa-thumbs-o-up fa-lg"></i> Quantidade recebida: <?= $pendindTradeOut['quantidadeCromoSaida'] ?> </p>
                            </div>
                        </div>


                <?php
                    	}
                    }

                	if(empty($pendindTradesIn) AND empty($pendindTradesOut)){
               	?>
               			<div id="jumbotron" class="jumbotron">
               			<h1 class="display-5">Não há trocas pendentes.</h1>
               			<p> Selecione as coleções incompletas e faça trocas com outros usuários.</p>
                		<a class="btn btn-primary btn-lg" href="/collections" role="button">Minhas coleções</a>
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