<?php namespace Config;

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
			'rules' => 'required',
		],
	];

	public $update_user = [
		'username' => [
			'rules' => 'required|min_length[5]|max_length[60]|is_unique[users.username,id,{id}]',
		],
		'password' => [
			'rules' => 'required',
		],
		'fullName' => [
			'rules' => 'required',
		],
		'email' => [
			'rules' => 'required',
		],
	];

	public $add_design = [
		'userID' => [
			'rules' => 'required',
		],
		'designName' => [
			'rules' => 'required',
		],
		'designType' => [
			'rules' => 'required',
		],
		'filePath' => [
			'rules' => 'required',
		],
		'detail' => [
			'rules' => 'required',
		],
	];

	public $update_design = [
		'userID' => [
			'rules' => 'required',
		],
		'designName' => [
			'rules' => 'required',
		],
		'designType' => [
			'rules' => 'required',
		],
		'filePath' => [
			'rules' => 'required',
		],
		'detail' => [
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
}
