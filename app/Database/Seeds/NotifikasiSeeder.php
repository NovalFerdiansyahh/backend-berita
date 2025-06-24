<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotifikasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'judul' => 'Artikel Baru!',
                'pesan' => 'Ada artikel baru yang mungkin kamu suka.',
                'dibaca' => false,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_notifikasi')->insertBatch($data);
    }
}
