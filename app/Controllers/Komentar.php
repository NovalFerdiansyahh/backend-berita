<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Komentar extends ResourceController
{
    protected $modelName = 'App\Models\KomentarModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $komentar = $this->model->find($id);
        if (!$komentar) {
            return $this->fail('Data tidak ditemukan');
        }

        return $this->respond($komentar);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $komentar = new \App\Entities\Komentar();
        $komentar->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($komentar)) {
            return $this->respondCreated($data);
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_komentar'] = $id;

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        $komentar = new \App\Entities\Komentar();
        $komentar->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($komentar)) {
            return $this->respondUpdated($data);
        }
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted("Komentar dengan id $id berhasil dihapus");
        }
    }
}
