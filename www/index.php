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
	$app->render("header.php", array("navItem" => "stickerbooks"));
	$app->render("stickerbooks.php");
	$app->render("footer.php");
});

// -- detalhar informacoes de um album
$app->get("/detail-stickerbook/:albumId", function ($albumId) use ($app)
{
	$album = StickerBook::detailStickerBook($albumId);
	$app->render("header.php");
	$app->render("detail-stickerbook.php" , array('album' => $album));
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
	$email = $app->request->post("email");
	if (($email == null) || (empty(trim($email))))
	{
		$errors["email"] = "Informe seu endereço de e-mail.";
	}
	$password = $app->request->post("password");	
	if (($password == null) || (empty(trim($password))))
	{
		$errors["password"] = "Informe sua senha.";
	}
	$confirm_password = $app->request->post("confirm_password");	
	if (($confirm_password == null) || (empty(trim($confirm_password))))
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
		// TODO inserir uma conta de usuário nova e efetuar login
		$_SESSION["user"] = array(
			"email" => $email
		);		
		$app->redirect("/stickerbooks");
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
		$uri = "/stickerbooks";
	}
	$app->render("header.php", array("navItem" => "login"));
	$app->render("login.php", array("uri" => $uri));
	$app->render("footer.php");
});

$app->post("/login/", function () use ($app)
{
	$uri = $app->request->post("uri");
	if ($uri == null)
	{
		$uri = "/stickerbooks";
	}
	$errors = array();
	$email = $app->request->post("email");
	if ($email == null)
	{
		$errors["email"] = "Informe seu endereço de e-mail.";
	}
	$password = $app->request->post("password");	
	if ($password == null)
	{
		$errors["password"] = "Informe sua senha.";
	}
	if (count($errors) == 0)
	{
		$_SESSION["user"] = array(
			"email" => $email
		);		
		$app->redirect($uri);
	} else {
		$app->render("header.php", array("navItem" => "login"));
		$data = array(
			"uri"     => $uri,
			"email"   => $email,
			"errors"  => $errors
		);
		$app->render("login.php", $data);
		$app->render("footer.php");
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
	if (count($errors) == 0)
	{
		$param = StickerBook::createStickerBook($titulo, $quantidadeCromo, $editora, $anoPublicacao, $idioma);

	    //$app->render('home.php', array('errMessage' => '', 'palavraChave' => '' , 'listaAlbuns' => $listaAlbuns));
		$app->redirect("/admin/detail-stickerbook.php");
	} else {
		$app->render("header.php", array("navItem" => "login"));
		$data = array(
			"titulo"   => $titulo,
			"errors"  => $errors
		);
		$app->render("/admin/update-stickerbook.php", $data);
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
$app->post("/admin/update-stickerbook/:albumId", function () use ($app)
{
	$albumId			= $app->request->post("albumId");
	$titulo				= $app->request->post("titulo");
	$editora			= $app->request->post("editora");
	$anoPublicacao		= $app->request->post("anoPublicacao");
	$idioma				= $app->request->post("idioma");
	$quantidadeCromo	= $app->request->post("quantidadeCromo");
	$album = StickerBook::updateStickerBook($albumId,$titulo, $quantidadeCromo, $editora, $anoPublicacao, $idioma);
	$stickers	= StickerBook::listSticker($albumId);
	$app->render("header.php");
		$data = array(
			"album"   => $album,
			"stickers"  => $stickers
	);
	$app->render("/admin/update-stickerbook.php" , $data);
	$app->render("footer.php");
});



$app->run();