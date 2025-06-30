<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_notifikasi';
    protected $primaryKey       = 'id_notifikasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Notifikasi';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'judul', 'pesan', 'dibaca', 'created_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'id_user' => 'required|integer',
        'judul'   => 'required|string|max_length[255]',
        'pesan'   => 'required|string',
        'dibaca'  => 'in_list[0,1]',
    ];
    protected $validationMessages   = [
        'id_user' => [
            'required' => 'ID User wajib diisi',
            'integer'  => 'ID User harus berupa angka',
        ],
        'judul' => [
            'required'    => 'Judul wajib diisi',
            'max_length'  => 'Judul maksimal 255 karakter',
        ],
        'pesan' => [
            'required' => 'Pesan wajib diisi',
        ],
        'dibaca' => [
            'in_list' => 'Status dibaca harus 0 atau 1',
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

    public function getJumlahBelumDibaca($idUser)
{
    return $this->where(['id_user' => $idUser, 'dibaca' => 0])->countAllResults();
}

}
