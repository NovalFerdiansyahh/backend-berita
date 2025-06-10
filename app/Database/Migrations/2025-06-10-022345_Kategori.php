<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_kategori'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => '100'],
        'deskripsi'     => ['type' => 'TEXT', 'null' => true],
        'created_at'    => ['type' => 'DATETIME', 'null' => true],
        'updated_at'    => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id_kategori', true);
    $this->forge->createTable('tb_kategori');
}


    public function down()
    {
        $this->forge->dropTable('tb_kategori');
    }
}
