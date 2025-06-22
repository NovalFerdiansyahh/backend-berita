<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $kategori = $this->model->find($id);
        if (!$kategori) {
            return $this->fail('Data tidak ditemukan');
        }

        return $this->respond($kategori);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $kategori = new \App\Entities\Kategori();
        $kategori->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($kategori)) {
            return $this->respondCreated($data);
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_kategori'] = $id;

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        $kategori = new \App\Entities\Kategori();
        $kategori->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($kategori)) {
            return $this->respondUpdated($data);
        }
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted("Data dengan id $id berhasil dihapus");
        }
    }
}
