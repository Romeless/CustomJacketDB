<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('header');
		echo view('users');
		echo view('designs');
		echo view('orders');
		echo view('footer');
	}

	//--------------------------------------------------------------------

}
