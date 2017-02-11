<?php
	if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Next Book</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
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
							<a href="/"><img src="images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="mainmenu pull-right">
							<ul class="nav navbar-nav ">
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
								<li><a href="/" class="active">Home</a></li>
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
					<!--<?php print_r($listaAlbuns); ?> -->
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Albuns</h2>
						<?php 
							$vars = get_defined_vars();

						    if (array_key_exists('listaAlbuns', $vars)) :

						  		foreach ($listaAlbuns as $item) {
						  									
									 
						?>						
						

						<div class="col-sm-2">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">	
											
											<img src="/images/capaAlbum/<?php echo $item['id'] ?>.jpg" alt="" class="img-responsive"  />
											
											<h3><?php echo substr($item['titulo'],0 , 25) ?></h3>
											<p> <?php echo $item['editora']  ?></p>											
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2><?php echo $item['titulo'] ?></h2>
												<p><?php echo $item['editora']  ?></p>
												<a href="/colecionar/<?php echo $item['id'] ?>/<?php echo $_SESSION['usuario']['id']?>" id="btn_<?php echo $item['id'] ?>/" class="btn btn-default "><i class="fa fa-book" ></i>Detalhes</a>
												<a href="/configurar/<?php echo $item['id'] ?>" id="btn_<?php echo $item['id'] ?>" class="btn btn-default "><i class="fa fa-book" ></i>Configurar</a>
											</div>
										</div>
								</div>
							</div>
						</div>
						<?php } endif; ?>
					</div><!--features_items-->
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
	
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>