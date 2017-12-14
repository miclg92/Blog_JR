<?php

namespace Core\Functions;

class Str{
	
	//	Définition d'une clé aléatoire (confirmation_token, reset_token, remember_token)
	static function str_random($length)
	{
		$alphabet = "0123456789azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}
	
}