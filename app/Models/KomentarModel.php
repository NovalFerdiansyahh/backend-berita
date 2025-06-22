<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_komentar';
    protected $primaryKey       = 'id_komentar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Komentar';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'id_artikel', 'isi_komentar', 'created_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'id_user'      => 'required|integer',
        'id_artikel'   => 'required|integer',
        'isi_komentar' => 'required|string',
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
        'isi_komentar' => [
            'required' => 'Komentar tidak boleh kosong',
            'string'   => 'Komentar harus berupa teks',
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
