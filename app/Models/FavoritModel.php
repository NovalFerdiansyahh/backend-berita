<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_favorit';
    protected $primaryKey       = 'id_favorit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Favorit'; 
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'id_artikel', 'created_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; 
    protected $deletedField  = ''; 

    protected $validationRules      = [
        'id_user'    => 'required|integer',
        'id_artikel' => 'required|integer',
    ];
    
    protected $validationMessages   = [
        'id_user' => [
            'required' => 'ID User wajib diisi',
            'integer'  => 'ID User harus berupa angka',
        ],
        'id_artikel' => [
            'required' => 'ID Artikel wajib diisi',
            'integer'  => 'ID Artikel harus berupa angka',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

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