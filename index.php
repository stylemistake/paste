<?php

// Bootstrap framework
require_once "vendor/autoload.php";

mb_internal_encoding("utf-8");

global $app;

$app = new \Slim\Slim(array(
	"debug" => true,
	"templates.path" => "app/templates",
));

// Load front app controller
include_once "app/app.php";
