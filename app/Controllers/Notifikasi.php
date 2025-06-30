<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NotifikasiModel;

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

    public function getByUser($id_user)
    {
        $model = new NotifikasiModel();
        $data = $model->where('id_user', $id_user)->orderBy('created_at', 'DESC')->findAll();

        if ($data) {
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    public function tandaiSudahDibaca($id_notifikasi)
    {
        $model = new NotifikasiModel();
        $notifikasi = $model->find($id_notifikasi);

        if (!$notifikasi) {
            return $this->failNotFound('Notifikasi tidak ditemukan');
        }

        $model->update($id_notifikasi, ['dibaca' => '1']);

        return $this->respond([
            'status' => 200,
            'message' => 'Notifikasi ditandai sudah dibaca'
        ]);
    }

    public function hapusSemua($idUser)
    {
        $model = new NotifikasiModel();

        $deleted = $model->where('id_user', $idUser)->delete();

        if ($deleted) {
            return $this->respond([
                'status' => 200,
                'message' => 'Semua notifikasi berhasil dihapus'
            ]);
        } else {
            return $this->failServerError('Gagal menghapus notifikasi');
        }
    }

    public function jumlahBelumDibaca($idUser)
    {
        $notifikasiModel = new NotifikasiModel();
        $jumlah = $notifikasiModel->getJumlahBelumDibaca($idUser);

        return $this->respond(['jumlah' => $jumlah]);
    }
}
