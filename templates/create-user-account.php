
<div class="container">
    
    <div class="row">
        <div id="card-create-user-account" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Criar minha conta</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite seu endereço de e-mail e crie uma senha.</h6>
            </div>
            <div class="card-block">
                <form id="from-create-user-account" method="post" action="">
                    <fieldset class="form-group">
                        <input id="input-email" class="form-control form-control-lg" name="email" type="email" placeholder="usuario@dominio.com">
                    </fieldset>
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" name="password" type="password" placeholder="Senha">
                    </fieldset>
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" type="password" placeholder="Confirme sua senha">
                    </fieldset>
                    <fieldset class="form-group">
                        <a id="link-create-user-account" href="#" role="button" class="btn btn-primary btn-lg btn-block">Criar conta</a>
                    </fieldset>
                </form>     
            </div>
        </div> 
    </div>

</div>

<style>

    #card-create-user-account {
        margin-top: 60px;
    }

</style>

<script type="text/javascript">

    $(document).ready(function()
    {
        
        $("#link-create-user-account").click(function()
        {
            $("#from-create-user-account").submit();
        });

    });

</script>