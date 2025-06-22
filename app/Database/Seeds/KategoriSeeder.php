<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Teknologi', 'deskripsi' => 'Artikel seputar teknologi.', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kategori' => 'Kesehatan', 'deskripsi' => 'Artikel seputar kesehatan.', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('tb_kategori')->insertBatch($data);
    }
}
