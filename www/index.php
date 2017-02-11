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


// Meus dados

$app->get("/user-account/", function () use ($app)
{
	$app->render("header.php");
	$app->render("user-account.php");
	$app->render("footer.php");
});


// Criar minh conta

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
		$app->redirect("/stickerbooks");
	} else {
		$app->render("header.php", array("navItem" => "login"));
		$data = array(
			"email"   => $email,
			"errors"  => $errors
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


$app->run();