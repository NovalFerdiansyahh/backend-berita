<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $user = $this->model->find($id);
        if (!$user) {
            return $this->fail('Data tidak ditemukan');
        }

        return $this->respond($user);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $user = new \App\Entities\User();
        $user->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($user)) {
            return $this->respondCreated($data);
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id_user'] = $id;

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        $user = new \App\Entities\User();
        $user->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($user)) {
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

    public function register()
    {
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->failValidationError('Data JSON tidak valid');
        }

        $data = [
            'nama'        => $json->nama,
            'email'       => $json->email,
            'no_telepon'  => $json->no_telepon,
            'password'    => $json->password, // ganti hash() jika mau pakai enkripsi
            'role'        => $json->role,
        ];

        // Validasi sederhana
        if (empty($data['nama']) || empty($data['email']) || empty($data['password'])) {
            return $this->fail('Semua field harus diisi', 400);
        }

        $this->model->insert($data);
        return $this->respondCreated(['message' => 'User berhasil terdaftar']);
    }
}
