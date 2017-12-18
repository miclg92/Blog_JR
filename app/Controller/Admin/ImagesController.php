<?php

namespace App\Controller\Admin;


class ImagesController extends AppController
{
	public function __construct()	{
		parent::__construct();
		$this->loadModel('Image');
	}

}