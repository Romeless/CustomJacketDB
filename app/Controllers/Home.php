<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('template/header');
		echo view("template/navbar");
		echo view('Home');
		echo view("template/footer");
	}

	//--------------------------------------------------------------------

}
