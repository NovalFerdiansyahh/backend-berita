<?php

namespace App\Controllers;
use App\Models\ArtikelModel;

use CodeIgniter\RESTful\ResourceController;

class Artikel extends ResourceController
{
    protected $modelName = 'App\Models\ArtikelModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $artikel = $this->model->find($id);
        if (!$artikel) {
            return $this->fail('Data tidak ditemukan');
        }
        
        return $this->respond($this->model->find($id));
    }

    public function create()
    {
        $data = $this->request->getPost();

        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {

            $namaFile = $fileGambar->getRandomName();

            $fileGambar->move('uploads', $namaFile);


            $data['gambar'] = base_url('uploads/' . $namaFile);
        }

        $artikel = new \App\Entities\Artikel();
        $artikel->fill($data);

        if (!$this->validate($this->model->validationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        if ($this->model->save($artikel)) {
            return $this->respondCreated($data);
        }

        return $this->failServerError('Gagal menyimpan data');
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        // Hanya validasi judul dan isi saat update
        $validationRules = [
            'judul' => 'required|min_length[5]',
            'isi' => 'required'
        ];
        $validationMessages = [
            'judul' => [
                'required' => 'Judul artikel wajib diisi',
                'min_length' => 'Judul minimal 5 karakter'
            ],
            'isi' => [
                'required' => 'Konten artikel tidak boleh kosong'
            ]
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }

        $data['id_artikel'] = $id;

        $artikel = new \App\Entities\Artikel();
        $artikel->fill($data);

        if ($this->model->save($artikel)) {
            return $this->respondUpdated($data);
        } else {
            return $this->fail('Gagal memperbarui artikel');
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
