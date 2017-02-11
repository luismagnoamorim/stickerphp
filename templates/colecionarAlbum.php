<?php
	if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Figurinha</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/prettyPhoto.css" rel="stylesheet">
    <link href="/css/price-range.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
	<link href="/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

    <link rel="stylesheet" href="/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css"/>
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  	<script src="/js/star-rating.min.js" type="text/javascript"></script>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="/images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="mainmenu pull-right">
							<ul class="nav navbar-nav">
								<?php
									if (!isset($_SESSION['usuario'])) {
								?>
										<li><a href="/login/"><i class="fa fa-lock"></i> Entrar</a></li>
								<?php 
									} else {
								?>
										<li class="dropdown"><a href="#"><i class="fa fa-user"></i> Olá, <?php echo $_SESSION['usuario']['nome'] ?><i class="fa fa-angle-down"></i></a>
                                    		<ul role="menu" class="sub-menu">
                                        		<li><a href="#">Dados</a></li>
												<li><a href="/logout/">Sair</a></li>
                                    		</ul>
                                		</li> 
								<?php
									} 	?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
										<li><a href="#">Blog List</a></li>
										<li><a href="#">Blog Single</a></li>
                                    </ul>
                                </li> 
								<li><a href="#">Contato</a></li>
								<li><a href="/pesquisar/">Pesquisar</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						
							<form action="" method="post">
				    			<div class="input-group">
      								<input type="text" class="form-control" id="palavraChave" name="palavraChave" placeholder="Título, autor ou ISBN" value="">
      								<span class="input-group-btn">
        								<button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
      								</span>
    							</div>
							</form>
						
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section>
		<div class="container">
			<div class="row">
				
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-3">
							<div class="view-product">
								<img src="src=/images/capaAlbum/<?php echo $album['id']?>.jpg" class="img-thumbnail" alt="" />
							</div>

						</div>

						<div class="col-sm-9">
							<div class="product-information"><!--/product-information-->

								<h2><?php echo $album['titulo']?></h2>
								<h2>Editora: <?php echo $album['editora']?></h2>
								
								
								<p><b>Quantidade Cromos:</b> <?php echo $album['quantidadeCromos']?></p>
								<p><b>Idioma:</b> <?php echo $album['idioma']?></p>
								
								
								<p><b>Data publicação:</b> <?php echo $album['dataPublicacao']?></p>
								<p><b>Formato:</b> <?php echo $album['formato']?></p>
								<p><b>Data inclusão:</b> <?php echo $album['dataInclusao']?></p>

								<form action="/incluirAlbumColecao/" method="post">
									<?php if (isset($_SESSION['usuario'])) { 
										$podeColecionar = true;
									?>
									<input type='hidden' id='usuario' name='usuarioId' value='<?php echo $_SESSION['usuario']['id']?>'>
									<input type='hidden' id='colecao' name='colecaoId' value='<?php echo $colecao['id']?>'>

									<?php } 
										else {
											$podeColecionar = false;
										}
									?>
									<input type='hidden' id='album' name='albumId' value='<?php echo $album['id'] ?>'>

									<button type="submit" class="btn btn-default">Colecionar</button>
								</form>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#cromos" data-toggle="tab">Cromos</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="cromos" >
								<div class="col-sm-12">
									<form>
										<table class="table table-striped table-bordered">

											<tbody>
												<tr id=info>
										        	<?php 
													$i = 0;
										  			foreach ($cromos as $cromo) {
										  				$i = $i + 1;


													  	if ($i % 10 == 0 ){
													?>
												     	<td align='center'>
												     	    <h2><?php echo $cromo['id'] ?></h2>

												     	    <button id="#btn_retira_<?php echo $cromo['id'] ?>" type="button" class="btn"><i class="fa fa-minus" ></i></button>
												     	    <button id="#btn_inclui_<?php echo $cromo['id'] ?>" type="button" class="btn"><i class="fa fa-plus"  ></i></button>
												     	    
															
															
												     	</td>
												     	</tr><tr id=info>
												    <?php
												      } else {
												    ?>
												      <td align='center'>
															<h2><?php echo $cromo['id'] ?></h2>
															<a href="/colecionar/<?php echo $cromo['id'] ?>" id="btn_<?php echo $cromo['id'] ?>/"><i class="fa fa-minus-square" ></i></a>
															<a href="/configurar/<?php echo $cromo['id'] ?>" id="btn_<?php echo $cromo['id'] ?>" ><i class="fa fa-plus-square" ></i></a>
												      </td>
												    <?php    
												      }
												    }
												    ?>
												</tr>
											</tbody>
										</table>
									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<!--<div class="footer-top">
			
		</div> -->
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <!--<script src="/js/jquery.js"></script> -->
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/jquery.scrollUp.min.js"></script>
	<script src="/js/price-range.js"></script>
    <script src="/js/jquery.prettyPhoto.js"></script>
    <script src="/js/main.js"></script>

	<script>
	    jQuery(document).ready(function () {
			$('.btn').click(function(e) {
	        	$colecaoId	= $("#colecao").attr('value');
	        	$usuarioId	= $("#usuario").attr('value');
	        	$acao 		= $(this).attr('id').split('_')[1];
	        	$cromoId	= $(this).attr('id').split('_')[2];
	        	if ($acao == "inclui") {
	 				$url = "/incluirCromoColecao";
	 			}
	 			else {
					$url = "/retirarCromoColecao";
	 			}
	 			alert($acao + '' + $url); 
	        	$.ajax({
	            	type: 'POST'
	             	,url: $url
	            	,dataType: 'html'
	            	,data: { colecaoId: $colecaoId , cromoId: $cromoId , usuarioId: $usuarioId } 
	            //,success: function(html){
	   			// 	$("#results").append(html);
	   			//        alert('textGoogleKey' + textGoogleKey);
	  			//}
	            ///,error: function(jqXHR, textStatus) {
	                //console.error("error");
	                    //alert('Not working!' + textStatus);
	            ///}
	            });	//$.ajax
	        });//btn.click
	        
	    });//jQuery
	</script>    
</body>
</html>