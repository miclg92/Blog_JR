<?php

// Création d'une constante ROOT qui ramène à la racine du site
define ('ROOT', dirname(__DIR__));

require ROOT . '/app/App.php';
App::load();

// Redirige vers l'action indiquée après ?p= dans la barre d'adresse
if(isset($_GET['p']))
{
	$page = $_GET['p'];
} else {
	$page = 'posts.index'; // Pointe vers index par défaut
}

$page = explode('.', $page);
if($page[0] == 'admin')
{
	$controller = '\App\Controller\Admin\\' . ucfirst($page[1]) . 'Controller';
	$action = $page[2];
} else {
	$controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
	$action = $page[1];
}

$controller = new $controller();
$controller->$action();
