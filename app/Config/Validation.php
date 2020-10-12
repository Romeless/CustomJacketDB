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

	//--------------------------------------------------------------------
	// USERS
	//--------------------------------------------------------------------

	public $register = [
		'username' => [
			'label' => 'username',
			'rules' => 'required|min_length[5]|max_length[60]|is_unique[users.username]',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'min_length' => 'Panjang {field} minimal 5 huruf',
				'max_length' => 'Panjang {field} maximal 60 huruf',
				'is_unique' => 'Username sudah diambil',
			],
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required|min_length[5]|max_length[60]',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'min_length' => 'Panjang {field} minimal 5 huruf',
				'max_length' => 'Panjang {field} maximal 60 huruf',
			],
		],
		'fullName' => [
			'label' => 'fullName',
			'rules' => 'required|max_length[250]',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'max_length' => 'Panjang {field} maximal 250 huruf',
			],
		],
		'email' => [
			'label' => 'email',
			'rules' => 'required|max_length[250]|valid_email',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'max_length' => 'Panjang {field} maximal 250 huruf',
				'valid_email' => 'Format email tidak valid!'
			],
		],
	];

	public $login = [
		'username' => [
			'label' => 'username',
			'rules' => 'required|max_length[60]',
			'errors' => [
				'required' => 'Tolong masukkan {field}',
				'max_length' => 'Panjang {field} maximal 60 huruf',
			],
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required|max_length[60]',
			'errors' => [
				'required' => 'Tolong masukkan {field}',
				'max_length' => 'Panjang {field} maximal 60 huruf',
			],
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
		'fullName' => [
			'rules' => 'max_length[250]',
		],
		'email' => [
			'rules' => 'valid_email|max_length[250]',
		],
		'address' => [
			'rules' => 'max_length[250]',
		],
	];

	public $role_validation = [
		'id' => [
			'rules' => 'required'
		],
		'role' => [
			'rules' => 'required'
		],
	];

	public $user_validation = [
		'id' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'ID tidak di input, harap Log-in!'
			],
		],
		'token' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'Token tidak di input, harap Log-in!'
			],
		],
	];

	//--------------------------------------------------------------------
	// DESIGN
	//--------------------------------------------------------------------

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

	public $design_update = [
		'userID' => [
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

	public $order_update = [
		'userID' => [
			'rules' => 'required',
		],
		'designID' => [
			'rules' => 'required',
		],
	];
}
