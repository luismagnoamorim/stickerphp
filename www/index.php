<?php

require "../vendor/autoload.php";

$app = new \Slim\Slim(array(
	"debug"          => true,
	"templates.path" => "../templates"
));

$app->add(new \AuthMiddleware());

// Home

$app->get("/", function () use ($app)
{
	$app->render("header.php");
	$app->render("home.php");
	$app->render("footer.php");
});

// Meus álbuns

$app->get("/stickerbooks/", function () use ($app)
{
	$stickerBooks = StickerBook::listStickerbooks();

	$app->render("header.php", array("navItem" => "stickerbooks"));
	$data = array(
			"stickerBooks"   => $stickerBooks
	);
	$app->render("stickerbooks.php" , $data);
	$app->render("footer.php");
});

// Meus dados

$app->get("/user-account/", function () use ($app)
{
	$app->render("header.php");
	$app->render("user-account.php");
	$app->render("footer.php");
});


// Criar minha conta

$app->get("/create-user-account/", function () use ($app)
{
	$app->render("header.php", array("navItem" => "create-user-account"));
	$app->render("create-user-account.php");
	$app->render("footer.php");
});

$app->post("/create-user-account/", function () use ($app)
{
	$errors = array();
	$email = trim($app->request->post("email"));
	if (empty($email))
	{
		$errors["email"] = "Informe seu endereço de e-mail.";
	}
	$password = trim($app->request->post("password"));
	if (empty($password))
	{
		$errors["password"] = "Informe sua senha.";
	}
	$confirm_password = trim($app->request->post("confirm_password"));
	if (empty($confirm_password))
	{
		$errors["confirm_password"] = "Informe sua senha novamente.";
	}
	if (!isset($errors["password"]) && !isset($errors["confirm_password"]))
	{
		if ($password != $confirm_password)
		{
			$app->flashNow("error", "As senhas informadas não conferem.");
			$errors["password"] = "";
			$errors["confirm_password"] = "";
		}
	}
	if (count($errors) == 0)
	{
		$usuarioLogado = StickerBook::insertBasicUser($email, $password);

		$_SESSION["user"] = array(
			 "email" => $email
			,"idUsuario" => $usuarioLogado->id
		);		
		$app->redirect("/collections");
	} else {
		$app->render("header.php", array("navItem" => "login"));
		$data = array(
			"email"            => $email,
			"password"         => $password,
			"confirm_password" => $confirm_password,
			"errors"           => $errors
		);
		$app->render("create-user-account.php", $data);
		$app->render("footer.php");
	}
});


// Login

$app->get("/login/", function () use ($app)
{
 	$uri = $app->request->post("uri");
	if ($uri == null)
	{
		$uri = "/collections";
	}
	$app->render("header.php", array("navItem" => "login"));
	$app->render("login.php", array("uri" => $uri));
	$app->render("footer.php");
});

$app->post("/login/", function () use ($app)
{
	$uri = $app->request->post("uri");
	if ($uri == null){
		$uri = "/collections";
	}
	$errors = array();
	$email = $app->request->post("email");
	if ($email == null){
		$errors["email"] = "Informe seu endereço de e-mail.";
	}
	$password = $app->request->post("password");	
	if ($password == null){
		$errors["password"] = "Informe sua senha.";
	}
	if (count($errors) == 0){
		$usuarioLogado = StickerBook::validateLogin($email, $password);
		//$loginValido = true;
	}
	if (is_null($usuarioLogado)) {
		$errors["email"] = "E-mail ou senha inválidos";
		
		$app->render("header.php", array("navItem" => "login"));
		$data = array(
			 "uri"     => $uri
			,"email"   => $email
			,"errors"  => $errors
		);
		$app->render("login.php", $data);
		$app->render("footer.php");		
	} else {
		$_SESSION["user"] = array(
			 "email" => $email
			,"idUsuario" => $usuarioLogado->id
		);		
		$app->redirect($uri);
	}
});


// Logout

$app->get("/logout/", function () use ($app)
{
	if (isset($_SESSION["user"]))
	{
		unset($_SESSION["user"]);
	}
	$app->redirect("/");
});


// Redefinir minha senha

$app->get("/reset-password/", function () use ($app)
{
	$app->render("header.php");
	$app->render("reset-password.php");
	$app->render("footer.php");
});

$app->post("/reset-password/", function () use ($app)
{
	$errors = array();
	$email = $app->request->post("email");
	if ($email == null)
	{
		$errors["email"] = "Informe seu endereço de e-mail.";
	}
	if (count($errors) == 0)
	{
		$app->flashNow("info", "Enviamos link para esse e-mail que autoriza a redefinição de senha.");
	}
	$app->render("header.php");
	$data = array(
		"email"   => $email,
		"errors"  => $errors
	);
	$app->render("reset-password.php", $data);
	$app->render("footer.php");
});

// area admin
// -- formulario para criacao de novo album
$app->get("/admin/create-stickerbook/", function () use ($app)
{
	$app->render("header.php");
	$app->render("/admin/create-stickerbook.php");
	$app->render("footer.php");
});
// -- criar novo album - metodo post para submeter formulario
$app->post("/admin/create-stickerbook/", function () use ($app)
{
	$errors = array();
	$titulo				= $app->request->post("titulo");
	$editora			= $app->request->post("editora");
	$anoPublicacao		= $app->request->post("anoPublicacao");
	$idioma				= $app->request->post("idioma");
	$quantidadeCromo	= $app->request->post("quantidadeCromo");
	$nomeImagem			= $app->request->post("nomeImagem");

	if ($titulo == null)
	{
		$errors["titulo"] = "Título do álbum deve ser informado.";
	}
	if ($editora == null)
	{
		$errors["editora"] = "Nome da editora deve ser informado.";
	}
	if ($anoPublicacao == null)
	{
		$errors["anoPublicacao"] = "Ano de publicação deve ser informado.";
	}
	if ($idioma == null)
	{
		$errors["idioma"] = "Idioma deve ser informado.";
	}
	if ($quantidadeCromo == null)
	{
		$errors["quantidadeCromo"] = "Quantidade total de cromos deve ser informada.";
	}
	if ($nomeImagem == null)
	{
		$errors["nomeImagem"] = "Nome da imagem da capa deve ser informada.";
	}
	if (count($errors) == 0)
	{
		$album = StickerBook::createStickerbook($titulo, $quantidadeCromo, $editora, $anoPublicacao, $idioma, $nomeImagem);
		$stickers = StickerBook::listSticker($album['id']);
		$app->render("header.php");
		$data = array(
				"album"   => $album,
				"stickers"  => $stickers
		);
		$app->render("/admin/update-stickerbook.php" , $data);
		$app->render("footer.php");

	} else {
		$app->render("header.php", array("navItem" => "login"));
		$data = array(
			"titulo"   => $titulo,
			"errors"  => $errors
		);
		$app->render("/admin/create-stickerbook.php", $data);
		$app->render("footer.php");
	}
});

// -- atualizar informacoes de um album existente
$app->get("/admin/update-stickerbook/:albumId", function ($albumId) use ($app)
{

	$album 		= StickerBook::detailStickerBook($albumId);
	$stickers	= StickerBook::listSticker($albumId);
	$app->render("header.php");
	$data = array(
			"album"   => $album,
			"stickers"  => $stickers
	);
	$app->render("/admin/update-stickerbook.php" , $data);
	$app->render("footer.php");
});
// -- recebe dados do formulario para atualizar um album existente
$app->post("/admin/update-stickerbook/:albumId", function () use ($app)
{
	$albumId			= $app->request->post("albumId");
	$titulo				= $app->request->post("titulo");
	$editora			= $app->request->post("editora");
	$anoPublicacao		= $app->request->post("anoPublicacao");
	$idioma				= $app->request->post("idioma");
	$quantidadeCromo	= $app->request->post("quantidadeCromo");
	$nomeImagem			= $app->request->post("nomeImagem");
	$album = StickerBook::updateStickerbook($albumId,$titulo, $quantidadeCromo, $editora, $anoPublicacao, $idioma, $nomeImagem);
	$stickers	= StickerBook::listSticker($albumId);
	$app->render("header.php");
		$data = array(
			"album"   => $album,
			"stickers"  => $stickers
	);
	$app->render("/admin/update-stickerbook.php" , $data);
	$app->render("footer.php");
});

$app->post("/admin/add-sticker-to-book/", function () use ($app)
{
	$albumId			= $app->request->post("albumId");
	$stickerList        = $app->request->post("newSticker");

	$album 				= StickerBook::addStickerToBook($albumId, $stickerList);
	$stickers			= StickerBook::listSticker($albumId);
	$app->render("header.php");
		$data = array(
			"album"   => $album,
			"stickers"  => $stickers
	);
	$app->render("/admin/update-stickerbook.php" , $data);
	$app->render("footer.php");
});

// -- atualizar informações de cromos existentes
$app->post("/admin/update-sticker/", function () use ($app)
{
	$stickerId  = $app->request->post("stickerId");
	$albumId    = $app->request->post("albumId");
	$novoCodigo = $app->request->post("novoCodigo");
	
	StickerBook::updateSticker($stickerId , $novoCodigo);
	//$stickers = StickerBook::listSticker($albumId);
	//$album 	  = StickerBook::detailStickerBook($albumId);

	//$app->render("header.php");
	//	$data = array(
	//		"album"   => $album,
	//		"stickers"  => $stickers
	//);
	//$app->render("/admin/update-stickerbook/:albumId" , $data);
	//$app->render("footer.php");
});

// -- detalhar informacoes de um album
$app->get("/detail-stickerbook/:albumId/:colecaoId", function ($albumId, $colecaoId) use ($app)
{
	//$albumId      = $app->request->post("albumId");
	//$colecaoId    = $app->request->post("colecaoId");
                                           
	$album 		  = StickerBook::detailStickerBook($albumId);
	$stickers 	  = StickerBook::listSticker($albumId);
	if ($colecaoId != 0){
		$userStickers = StickerBook::listStickerCollection($colecaoId);
	} else {
		$userStickers = null;
	}
	
	$app->render("header.php");
	$data = array(
			  "album"        => $album
			, "stickers"     => $stickers
			, "colecaoId"    => $colecaoId
			, "userStickers" => $userStickers
	);	
	$app->render("/detail-stickerbook.php" , $data);
	$app->render("footer.php");
});

// -- incluir um stickerbook na collection de um usuario
$app->get("/collection/stickerbook/add/:albumId", function ($albumId) use ($app)
{
	//$albumId   = $app->request->post("albumId");
	$usuarioId = $_SESSION['user']['idUsuario'];
	//$usuarioId = 1;

	$album     	  = StickerBook::detailStickerBook($albumId);
	$stickers  	  = StickerBook::listSticker($albumId);
	$colecao   	  = StickerBook::addStickerbookToCollection($albumId, $usuarioId);
	$userStickers = StickerBook::listStickerCollection($colecao->id);
   
	$app->render("header.php");
		$data = array(
			  "album"   		=> $album
			, "stickers"		=> $stickers 
			, "colecaoId"		=> $colecao->id
			, "userStickers"	=> $userStickers
	
	);
	$app->render("/detail-stickerbook.php" , $data);
	$app->render("footer.php");
});

// -- incluir um stickerbook na collection de um usuario
$app->get("/collection/stickerbook/remove/:colecaoId", function ($colecaoId) use ($app)
{
	//$colecaoId = $app->request->post("colecaoId");
	$usuarioId = $_SESSION['user']['idUsuario'];
	$album 	   = StickerBook::removeStickerbookFromCollection($colecaoId, $usuarioId);
	$stickers  = StickerBook::listSticker($album->id);
   
	$app->render("header.php");
		$data = array(
			  "album"   => $album
			, "colecaoId" => 0	
			, "stickers"  => $stickers 
	);
	$app->render("/detail-stickerbook.php" , $data);
	$app->render("footer.php");
});

// -- adicionar ou remover cromo a uma colecao
$app->post("/updateCollection/", function () use ($app)
{
	$colecaoId = $app->request->post("colecaoId");
	$cromoId   = $app->request->post("cromoId");
	$acao      = $app->request->post("acao");

	$collection   = StickerBook::updateCollection($colecaoId , $cromoId , $acao );
	$album        = StickerBook::findAlbumByCollection($colecaoId);
	$stickers     = StickerBook::listSticker($_SESSION['user']['idUsuario']);    
	$userStickers = StickerBook::listStickerCollection($colecaoId) ;

	//$app->render("header.php");
	//	$data = array(
	//		  "album"   => $album
	//		, "stickers"  => $stickers 
	//		, "userStickers"  => $userStickers
	//);
	//$app->render("/detail-stickerbook.php" , $data);
	//$app->render("footer.php");
});

// -- detalhar informacoes de um album
$app->get("/collections/", function () use ($app)
{
	//$usuarioId = $app->request->post("usuarioId");
	$userCollections = [];
	$usuarioId = $_SESSION['user']['idUsuario'];
	//$usuarioId = 1;

	$collections  = StickerBook::listStickerBookCollection($usuarioId);
    if (!is_null($collections)){
		foreach ($collections as $collection) {
			$userStickers = StickerBook::listStickerCollection($collection->id);
			$collection->userStickers = $userStickers;
			$userCollections[] = $collection;
		}
	}

	$app->render("header.php");
	$data = array(
			  	"collections"	=> $userCollections
	);	
	$app->render("/collections.php" , $data);
	$app->render("footer.php");
});


// ===============================================================================================================
// ============================= AREA DE NEGOGICIAÇÕES DE FIGURINHAS - TRADES   ==================================
// ===============================================================================================================
// -- pagina principal das trocas de figurinhas
$app->get("/trade/", function () use ($app)
{
	$userId = $_SESSION['user']['idUsuario'];
	$stickerbook = null;
	$pendindTradesIn  = StickerBook::listPendindTradeIn($userId);
	$pendindTradesOut = StickerBook::listPendindTradeOut($userId);
	if (!empty($pendindTradesIn)) {
		$pendindTrade = reset($pendindTradesIn);
		$stickerbook      = StickerBook::findAlbumByCollection($pendindTrade->colecao_entrada);	
	} else if (!empty($pendindTradesOut)) {
		$pendindTrade = reset($pendindTradesOut);
		$stickerbook      = StickerBook::findAlbumByCollection($pendindTrade->colecao_entrada);	
	}
	
		
	$app->render("header.php");
	$data = array(
			    "pendindTradesIn"	=> $pendindTradesIn
			  ,	"pendindTradesOut"	=> $pendindTradesOut
			  , "stickerbook"		=> $stickerbook
	);	
	$app->render("/trades.php" , $data);
	$app->render("footer.php");
});

// -- pagina principal das trocas de figurinhas
$app->get("/trade/findtrader/:myCollection", function ($myCollection) use ($app)
{
	$usuarioId = $_SESSION['user']['idUsuario'];
	
	//TODO implementar verificação da colecao do usuario
		
	$app->render("header.php");
	$data = array(
			  	"collectionId"	   => $myCollection
	//		  ,	"stickersOut"	   => $stickersOut		
	//		  , "stickersRepeated" => $stickersRepeated
	);	
	$app->render("/search-trader.php" , $data);
	$app->render("footer.php");
});

//retornar JSON com emails dos usuarios - NÃO RENDERIZA PAGINA
$app->get("/trade/trader/:query", function ($query) use ($app)
{
	$traders  = StickerBook::listTraders($query);
	echo json_encode($traders);
});

//URL para listar collections de um usuario - NÃO RENDERIZA PAGINA
$app->get("/trade/trader/collection/:traderId/:collectionId", function ($traderEmail, $collectionId) use ($app)
{
	$collections  = StickerBook::listStickerBookCollectionByEmail($traderEmail, $collectionId);
	//echo json_encode($collections);
	if(!empty($collections)){
		foreach ($collections as $collection) {
			echo '
			    <div class="input-group col-sm-4">
	                <div class="thumbnail">
	                   	<a href="/trade/negotiate/'.$collectionId.'/'.$collection->id.'">
	                        <img src="/img/capas/'.$collection->album->nomeImagem.'.jpg" style="width:50%">
	                   		<div class="caption">
	                  			'.$collection->album->titulo.'
	                   		</div>
	                    </a>
	                </div>
	            </div>';
		}
	}
});

// -- pagina para propor a troca de figurinhas
$app->get("/trade/negotiate/:colecaoAId/:colecaoBId", function ($colecaoAId, $colecaoBId) use ($app)
{
	$usuarioId = $_SESSION['user']['idUsuario'];

	$stickersIn  = StickerBook::listMissingSticker($colecaoAId , $colecaoBId);
	$stickersOut = StickerBook::listMissingSticker($colecaoBId , $colecaoAId);

	$stickersRepeated = StickerBook::listRepeatedSticker($colecaoAId);
	
	$app->render("header.php");
	$data = array(
			  	"stickersIn"	   => $stickersIn
			  ,	"stickersOut"	   => $stickersOut
			  , "stickersRepeated" => $stickersRepeated
			  , "collectionIn"	   => $colecaoAId
			  , "collectionOut"	   => $colecaoBId
	);	
	$app->render("/prepare-trade.php" , $data);
	$app->render("footer.php");
});

// -- gravar solicitação de troca
$app->post("/trade/negotiate/save/", function () use ($app)
{
	$usuarioId	= $_SESSION['user']['idUsuario'];
	$colecaoId	= $app->request->post("colecaoId");
	//$colecaoBId		= $app->request->post("colecaoBId");
	$arrEntrada	= $app->request->post("arrEntrada");
	$arrSaida	= $app->request->post("arrSaida");
	//$usuarioIdOut	= StickerBook::detailCollection($colecaoBId);

	$trade   = StickerBook::saveTrade($usuarioId , $colecaoId , $arrEntrada , $arrSaida );

	$album 		= StickerBook::findAlbumByCollection($colecaoId);
	$stickers 	= StickerBook::listSticker($album->id);
	if ($colecaoId != 0){
		$userStickers = StickerBook::listStickerCollection($colecaoId);
	} else {
		$userStickers = null;
	}	

	$app->render("header.php");
	$data = array(
			  "album"        => $album
			, "stickers"     => $stickers
			, "colecaoId"    => $colecaoId
			, "userStickers" => $userStickers
	);	
	$app->render("/detail-stickerbook.php" , $data);
	$app->render("footer.php");
});

$app->run();