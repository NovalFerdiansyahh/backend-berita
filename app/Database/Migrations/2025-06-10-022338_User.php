<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_user'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'nama'           => ['type' => 'VARCHAR', 'constraint' => '100'],
        'email'          => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
        'password'       => ['type' => 'VARCHAR', 'constraint' => '255'],
        'tanggal_lahir'  => ['type' => 'DATE', 'null' => true],
        'no_telepon'     => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
        'foto_profil'    => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
        'role'           => ['type' => 'ENUM', 'constraint' => ['pembaca', 'penulis'], 'default' => 'pembaca'],
        'created_at'     => ['type' => 'DATETIME', 'null' => true],
        'updated_at'     => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id_user', true);
    $this->forge->createTable('tb_users');
}


    public function down()
    {
        $this->forge->dropTable('tb_users');
    }
}
