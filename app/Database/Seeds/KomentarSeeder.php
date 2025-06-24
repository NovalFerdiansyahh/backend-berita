<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KomentarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'id_artikel' => 1,
                'isi_komentar' => 'sangat bagus',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_komentar')->insertBatch($data);
    }
}