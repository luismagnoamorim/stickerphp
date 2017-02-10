<?php

require "../vendor/autoload.php";

session_start();

$app = new \Slim\Slim(array(
	"debug" => true,
	"templates.path" => "../templates"
));


// home

$app->get("/", function () use ($app)
{
	$app->redirect("/stickerbooks");
});


// Álbuns de Figurinhas

$app->get("/stickerbooks/", function () use ($app)
{
	$dados = array(
		"usuario" => array(
			"email" => "fabiosvm@outlook.com"
		)
	);
	$app->render("header.php", $dados);
	$app->render("stickerbooks.php");
	$app->render("footer.php");
});

$app->run();