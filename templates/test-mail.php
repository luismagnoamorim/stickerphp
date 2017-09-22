<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
// If you are using Composer (recommended)
require "../vendor/autoload.php";
$from = new SendGrid\Email("StickerTrade", "suporte@stickertrade.com");
$subject = "Sending with SendGrid is Fun";
$to = new SendGrid\Email("Luis Magno", "luismagno@hotmail.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
print_r($response->headers());
echo $response->body();
