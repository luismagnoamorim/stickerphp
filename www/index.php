<?php

require '../vendor/autoload.php';

session_start();

$app = new \Slim\Slim(array(
	'debug' => true,
	'templates.path' => '../templates'
));

// home

$app->get('/', function () use ($app)
{
	$app->render('home.php');
});

$app->run();