<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Komentar extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_komentar'  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'id_user'      => ['type' => 'INT', 'unsigned' => true],
        'id_artikel'   => ['type' => 'INT', 'unsigned' => true],
        'isi_komentar' => ['type' => 'TEXT'],
        'created_at'   => ['type' => 'DATETIME', 'null' => true],
        'updated_at'   => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id_komentar', true);
    $this->forge->addForeignKey('id_user', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('id_artikel', 'tb_artikel', 'id_artikel', 'CASCADE', 'CASCADE');
    $this->forge->createTable('tb_komentar');
}


    public function down()
    {
        $this->forge->dropTable('tb_komentar');
    }
}
