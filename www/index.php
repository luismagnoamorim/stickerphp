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
	$dados = array(
		"navItem" => "stickerbooks"
	);
	$app->render("header.php", $dados);
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
	$dados = array(
		"navItem" => "create-user-account"
	);	
	$app->render("header.php", $dados);
	$app->render("create-user-account.php");
	$app->render("footer.php");
});


// Login

$app->get("/login/", function () use ($app)
{
	$dados = array(
		"navItem" => "login"
	);	
	$app->render("header.php", $dados);
	$app->render("login.php");
	$app->render("footer.php");
});

$app->post("/login/", function () use ($app)
{
	$uri      = $app->request->post("uri");
	$email    = $app->request->post("email");
	$password = $app->request->post("password");
	
	// TODO

	$_SESSION["user"] = array(
		"email" => $email
	);
	
	$app->redirect($uri);
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
	echo "TODO POST /reset-password\n";
});


$app->run();