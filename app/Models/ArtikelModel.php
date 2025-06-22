<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_artikel';
    protected $primaryKey       = 'id_artikel';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Artikel'; 
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'judul', 'isi', 'gambar', 'created_at', 'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = ''; 

    // Validation
    protected $validationRules      = [
        'id_user' => 'required|integer',
        'judul' => 'required|min_length[5]',
        'isi' => 'required',
    ];
    
    protected $validationMessages   = [
        'id_user' => [
            'required' => 'ID User harus diisi',
            'integer' => 'ID User harus berupa angka',
        ],
        'judul' => [
            'required' => 'Judul artikel wajib diisi',
            'min_length' => 'Judul minimal 5 karakter',
        ],
        'isi' => [
            'required' => 'Konten artikel tidak boleh kosong',
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

    public function getTerkini($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    // Ambil artikel paling banyak dilihat
    public function getTrending($limit = 5)
    {
        return $this->orderBy('dilihat', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
