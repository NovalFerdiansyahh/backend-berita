<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Artikel extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_artikel'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'id_user'      => ['type' => 'INT', 'unsigned' => true],
        'id_kategori'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
        'judul'        => ['type' => 'VARCHAR', 'constraint' => '255'],
        'isi'          => ['type' => 'TEXT'],
        'gambar'       => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
        'dilihat'      => ['type' => 'INT', 'default' => 0],
        'created_at'   => ['type' => 'DATETIME', 'null' => true],
        'updated_at'   => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id_artikel', true);
    $this->forge->addForeignKey('id_user', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('id_kategori', 'tb_kategori', 'id_kategori', 'SET NULL', 'CASCADE');
    $this->forge->createTable('tb_artikel');
}


    public function down()
    {
        $this->forge->dropTable('tb_artikel');
    }
}
