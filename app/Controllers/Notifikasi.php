<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Notifikasi extends ResourceController
{
    protected $modelName = 'App\Models\NotifikasiModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $notifikasi = $this->model->find($id);
        if (!$notifikasi) {
            return $this->fail('Data tidak ditemukan');
        }

        return $this->respond($notifikasi);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $notifikasi = new \App\Entities\Notifikasi();
        $notifikasi->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($notifikasi)) {
            return $this->respondCreated($data);
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_notifikasi'] = $id;

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        $notifikasi = new \App\Entities\Notifikasi();
        $notifikasi->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($notifikasi)) {
            return $this->respondUpdated($data);
        }
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted("Notifikasi dengan id $id berhasil dihapus");
        }
    }
}
