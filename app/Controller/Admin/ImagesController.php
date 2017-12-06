<?php

namespace App\Controller\Admin;


class ImagesController extends AppController
{
	public function __construct()	{
		parent::__construct();
		$this->loadModel('Image');
	}
	
//	public function index()	{
//		$images = $this->Image->all();
//		$this->render('admin.images.index', compact('images'));
//	}
//
	
	
}