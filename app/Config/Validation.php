<?php

namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------


	public $register = [
		'username' => [
			'rules' => 'required|min_length[5]|max_length[60]|is_unique[users.username]',
		],
		'password' => [
			'rules' => 'required',
		],
		'fullName' => [
			'rules' => 'required',
		],
		'email' => [
			'rules' => 'required|valid_email',
		],
	];

	public $google_auth = [
		'tokenID' => [
			'rules' => 'required'
		],
		'fullName' => [
			'rules' => 'required',
		],
		'email' => [
			'rules' => 'required|valid_email',
		],
	];

	public $update_user = [
		'username' => [
			'rules' => 'required|min_length[5]|max_length[60]|is_unique[users.username,id,{id}]',
		],
		'fullName' => [
			'rules' => 'required',
		],
		'email' => [
			'rules' => 'required|valid_email',
		],
	];

	public $design_validation = [
		'userID' => [
			'rules' => 'required',
		],
		'designName' => [
			'rules' => 'required',
		],
		'details' => [
			'rules' => 'required',
		],
	];

	public $design_remove = [
		'userID' => [
			'rules' => 'required',
		],
	];

	public $login = [
		'username' => [
			'rules' => 'required',
		],
		'password' => [
			'rules' => 'required',
		],
	];

	public $order_validation = [
		'userID' => [
			'rules' => 'required',
		],
		'designID' => [
			'rules' => 'required',
		],
		'qty' => [
			'rules' => 'required',
		],
		'price' => [
			'rules' => 'required',
		],
		'information' => [
			'rules' => 'required',
		],
	];
}
