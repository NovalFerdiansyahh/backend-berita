<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Favorit extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_favorit'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'id_user'      => ['type' => 'INT', 'unsigned' => true],
        'id_artikel'   => ['type' => 'INT', 'unsigned' => true],
        'created_at'   => ['type' => 'DATETIME', 'null' => true],
        'updated_at'   => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id_favorit', true);
    $this->forge->addForeignKey('id_user', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('id_artikel', 'tb_artikel', 'id_artikel', 'CASCADE', 'CASCADE');
    $this->forge->createTable('tb_favorit');
}


    public function down()
    {
        $this->forge->dropTable('tb_favorit');
    }
}
