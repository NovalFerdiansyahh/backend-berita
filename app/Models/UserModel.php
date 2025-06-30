<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\User'; 
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama', 'email', 'password', 'tanggal_lahir',
        'no_telepon', 'foto_profil', 'role', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = ''; 

    // Validation
    protected $validationRules      = [
        'id_user'       => 'permit_empty|numeric',
        'nama' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[tb_users.email,id_user,{id_user}]',
        'password' => 'required|min_length[6]',
        'password'      => 'permit_empty|min_length[6]',
        'tanggal_lahir' => 'required|valid_date',
        'no_telepon'    => 'required|min_length[8]',
    ];
    
    protected $validationMessages   = [
        'nama' => [
            'required' => 'Nama wajib diisi',
            'min_length' => 'Nama minimal 3 karakter',
        ],
        'email' => [
            'required' => 'Email wajib diisi',
            'valid_email' => 'Email tidak valid',
            'is_unique' => 'Email sudah terdaftar',
        ],

    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
