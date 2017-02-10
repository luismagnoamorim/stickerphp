
<div class="container">
    <div class="row">
        <div id="card-reset-password" class="card col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="card-block">
                <h4 class="card-title text-center">Redefinir minha senha</h4>
                <br>
                <h6 class="card-subtitle text-muted text-center">Digite seu endereço de e-mail para redefinir sua senha.</h6>
            </div>
            <div class="card-block">
                <form id="form-reset-password" method="post" action="">
                    <fieldset class="form-group">
                        <input class="form-control form-control-lg" name="email" type="email" placeholder="usuario@dominio.com">
                    </fieldset>
                    <fieldset class="form-group">
                        <a id="link-reset-password" href="#" role="button" class="btn btn-primary btn-lg btn-block">Redefinir senha</a>
                    </fieldset>
                </form>     
            </div>
        </div> 
    </div>
</div>

<style>

    #card-reset-password {
        margin-top: 60px;
    }

</style>

<script type="text/javascript">

    $(document).ready(function()
    {
        
        $("#link-reset-password").click(function()
        {
            $("#form-reset-password").submit();
        });

    });

</script>