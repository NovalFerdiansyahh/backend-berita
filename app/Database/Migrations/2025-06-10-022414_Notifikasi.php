<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notifikasi extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_notifikasi' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'id_user'       => ['type' => 'INT', 'unsigned' => true],
        'judul'         => ['type' => 'VARCHAR', 'constraint' => 255],
        'pesan'         => ['type' => 'TEXT'],
        'dibaca'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        'created_at'    => ['type' => 'DATETIME', 'null' => true],
        'updated_at'    => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id_notifikasi', true);
    $this->forge->addForeignKey('id_user', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
    $this->forge->createTable('tb_notifikasi');
}


    public function down()
    {
        $this->forge->dropTable('tb_notifikasi');
    }
}
