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
			'label' => 'Username',
			'rules' => 'required|min_length[5]|max_length[60]|is_unique[users.username]',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'min_length' => 'Panjang {field} minimal 5 huruf',
				'max_length' => 'Panjang {field} maksimal 60 huruf',
				'is_unique' => 'Username sudah diambil',
			],
		],
		'password' => [
			'label' => 'Password',
			'rules' => 'required|min_length[5]|max_length[60]',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'min_length' => 'Panjang {field} minimal 5 huruf',
				'max_length' => 'Panjang {field} maksimal 60 huruf',
			],
		],
		'fullName' => [
			'label' => 'Nama Panjang',
			'rules' => 'required|max_length[250]',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'max_length' => 'Panjang {field} maksimal 250 huruf',
			],
		],
		'email' => [
			'label' => 'Email',
			'rules' => 'required|max_length[250]|valid_email',
			'errors' => [
				'required' => 'Semua akun membutuhkan {field}',
				'max_length' => 'Panjang {field} maksimal 250 huruf',
				'valid_email' => 'Format email tidak valid!'
			],
		],
	];

	public $login = [
		'username' => [
			'label' => 'Username',
			'rules' => 'required|max_length[60]',
			'errors' => [
				'required' => 'Tolong masukkan {field}',
				'max_length' => 'Panjang {field} maksimal 60 huruf',
			],
		],
		'password' => [
			'label' => 'Password',
			'rules' => 'required|max_length[60]',
			'errors' => [
				'required' => 'Tolong masukkan {field}',
				'max_length' => 'Panjang {field} maksimal 60 huruf',
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
			'label' => 'Nama Panjang',
			'rules' => 'max_length[250]',
			'errors' => [
				'max_length' => 'Panjang {field} maksimal 60 huruf',
			],
		],
		'email' => [
			'label' => 'Email',
			'rules' => 'valid_email|max_length[250]',
			'errors' => [
				'valid_email' => 'Format email tidak valid',
				'max_length' => 'Panjang {field} maksimal 250 huruf',
			],
		],
		'address' => [
			'label' => 'Alamat',
			'rules' => 'max_length[250]',
			'errors' => [
				'max_length' => 'Panjang {field} maksimal 250 huruf',
			],
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
			'label' => 'Pembuat design',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera'
			]
		],
		'designName' => [
			'label' => 'Nama design',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera',
			],
		],
		'details' => [
			'label' => 'Details',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} dibutuhkan',
			],
		],
	];

	public $design_update = [
		'userID' => [
			'label' => 'Pembuat design',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera'
			]
		],
	];

	public $order_validation = [
		'userID' => [
			'label' => 'Pembuat order',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera'
			]
		],
		'designID' => [
			'label' => 'Design',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera'
			]
		],
		'qty' => [
			'label' => 'Kuantitas',
			'rules' => 'required|greater_than[0]',
			'errors' => [
				'required' => '{field} tidak tertera',
				'greater_than' => '{field} harus angka positif'
			]
		],
		'price' => [
			'label' => 'Design',
			'rules' => 'required|greater_than[0]',
			'errors' => [
				'required' => '{field} tidak tertera',
				'greater_than' => '{field} harus angka positif'
			]
		]
	];

	public $order_update = [
		'userID' => [
			'label' => 'Pembuat order',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera'
			]
		],
		'designID' => [
			'label' => 'Design',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} tidak tertera'
			]
		],
	];

	public $verify_token = [
		'token' => [
			'label' => 'Token',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} dibutuhkan'
			],
			'email' => [
				'label' => 'Email',
				'rules' => 'required',
				'errors' => [
					'required' => '{email} dibutuhkan'
				]
			]
		]
	];

	public $verify_google_token = [
		'token' => [
			'label' => 'Token',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} dibutuhkan'
			]
		]
	];

}
