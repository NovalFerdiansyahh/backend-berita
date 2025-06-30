<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Favorit extends ResourceController
{
    protected $modelName = 'App\Models\FavoritModel';
    protected $format    = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_favorit');

        $builder->select('
            tb_favorit.*,
            tb_artikel.judul,
            tb_artikel.gambar,
            tb_users.nama AS sumber
        ');
        $builder->join('tb_artikel', 'tb_artikel.id_artikel = tb_favorit.id_artikel');
        $builder->join('tb_users', 'tb_users.id_user = tb_artikel.id_user');

        $query = $builder->get();
        $results = $query->getResultArray();

        return $this->response->setJSON($results);
    }
    public function show($id = null)
    {
        $favorit = $this->model->find($id);
        if (!$favorit) {
            return $this->fail('Data tidak ditemukan');
        }

        return $this->respond($favorit);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $favorit = new \App\Entities\Favorit();
        $favorit->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($favorit)) {
            return $this->respondCreated($data);
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_favorit'] = $id;

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        $favorit = new \App\Entities\Favorit();
        $favorit->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($favorit)) {
            return $this->respondUpdated($data);
        }
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted("Favorit dengan id $id berhasil dihapus");
        }
    }
    public function simpan()
{
    $json = $this->request->getJSON();

    if (!isset($json->id_user) || !isset($json->id_artikel)) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Data tidak lengkap'
        ])->setStatusCode(400);
    }

    $data = [
        'id_user'    => $json->id_user,
        'id_artikel' => $json->id_artikel,
    ];

    $favoritModel = new \App\Models\FavoritModel();
    if ($favoritModel->insert($data)) {
        return $this->response->setJSON(['status' => true, 'message' => 'Berhasil disimpan']);
    } else {
        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menyimpan']);
    }
}


}
