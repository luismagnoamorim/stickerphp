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
                                    	<img src='/img/capas/<?=$stickerBook['id']?>.jpg' style="width:50%">
                                    
                                		<div class='caption'>
                                			<a href='/detail-stickerbook/<?=$stickerBook['id']?>/<?=$stickerBook['id'] ?>'><?= $stickerBook['titulo'] ?></a>
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