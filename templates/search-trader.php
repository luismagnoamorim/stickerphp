<?php
    //collections PHP - exibe os albuns incluidos pelo usuario
    $email = isset($email)? $email: "";
    $collectionId = isset($collectionId)? $collectionId: "";

?>

<div class="container-fluid">
    <div class="row">
        <div id="users" class="col-md-12">
            <br/>
            <h1>Pesquisar traders</h1>   
            <input class="typeahead form-control" style="margin:0px auto;width:300px;" type="text" placeholder="Email" id="email-trader">
            <input type="hidden" id="collection-id" value="<?= $collectionId?>">
            <button class="btn btn-primary" id="btn-trader">Ok</button>
        </div>
    </div>
    <div class="row" id="trader-collection">
    </div>
</div>


<script>
jQuery(document).ready(function () {
    var userTrader = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      
      remote: {
        url: '/trade/trader/%QUERY',
        wildcard: '%QUERY'
      }
    });

    $('#users .typeahead').typeahead(
        {
            highlight: true,
            hint: false,
            minLength: 3,
            limit: 5
        }, {
            name: 'best-pictures',
            display: 'email',
            source: userTrader
        }
    );

    $('#btn-trader').on('click' , function(e) {
            $traderId     = $("#email-trader").val();
            $collectionId = $("#collection-id").val();
            $url        = "/trade/trader/collection/" + $traderId + "/" + $collectionId;
            //alert($url);
            $.ajax({
                type: 'GET'
                ,url: $url
                ,dataType: 'html'
                //,data: { $traderId } 
            ,success: function(data){
                $('#trader-collection').html(data);
            }
            ///,error: function(jqXHR, textStatus) {
                //console.error("error");
                    //alert('Not working!' + textStatus);
            ///}
            }); //$.ajax
    });//btn.click  

});
</script>