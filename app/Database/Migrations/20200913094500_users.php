<?php
namespace App\Database\Migrations;

class Users extends \CodeIgniter\Database\Migration
{

    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'  => 'INT',
                'contraint' => 11,
                'auto_increment' => true,
            ],
            'username'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '255',
            ],
            'fullName'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '255',
            ],
            'password'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '255',
            ],
            'salt'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '255',
            ],
            'email'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '255',
            ],
            'address'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '255',
                'null'  => TRUE,
            ],
            'phoneNumber'  => [
                'type'  => 'VARCHAR',
                'constraint'    => '16',
                'null'  => TRUE,
            ],
            'joinDate'  => [
                'type'  => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}