<?php

namespace Core\Controller;

class Controller
{
	protected $viewPath; // Chemin vers le dossier qui contient les vues
	protected $template;
	
	/* Afficher les vues pour le visiteur */
	protected function render($view, $variables = [])
	{
		ob_start();
		extract($variables); // Variables $posts, $categories, $comments....
		require($this->viewPath . str_replace('.', '/', $view) . '.php');
		$content = ob_get_clean();
		require($this->viewPath . 'templates/' . $this->template . '.php');
	}
	
	protected function forbidden()
	{
		header('HTTP/1.0 403 Forbidden');
		die('Acces interdit');
	}
	
	protected function notFound()
	{
		header('HTTP/1.0 404 Not found');
		die('Page introuvable');
	}
	
	//	Définition d'une clé aléatoire (confirmation_token, reset_token, remember_token)
	protected function str_random($length)
	{
		$alphabet = "0123456789azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}
	
	
}