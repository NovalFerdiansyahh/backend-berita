<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'id_kategori' => 1,
                'judul' => 'Masa Depan AI',
                'isi' => 'Konten artikel tentang AI...',
                'gambar' => null,
                'dilihat' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ],
        ];

        $this->db->table('tb_artikel')->insertBatch($data);
    }
}
