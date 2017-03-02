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

</div>