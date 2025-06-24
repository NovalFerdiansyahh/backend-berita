<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FavoritSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'id_artikel' => 1,
                'created_at' => date(format: 'Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('tb_favorit')->insertBatch($data);
    }
}
