<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Admin Penulis',
                'email' => 'penulis@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'tanggal_lahir' => '1995-06-01',
                'no_telepon' => '08123456789',
                'foto_profil' => null,
                'role' => 'penulis',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama' => 'User Pembaca',
                'email' => 'pembaca@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'tanggal_lahir' => '2000-01-01',
                'no_telepon' => '08987654321',
                'foto_profil' => null,
                'role' => 'pembaca',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_users')->insertBatch($data);
    }
}
