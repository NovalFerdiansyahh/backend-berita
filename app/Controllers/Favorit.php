<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Favorit extends ResourceController
{
    protected $modelName = 'App\Models\FavoritModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
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
}
