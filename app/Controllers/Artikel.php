<?php

namespace App\Controllers;
use App\Models\ArtikelModel;
use App\Models\NotifikasiModel;
use App\Models\UserModel;

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
        $db = \Config\Database::connect();
        $builder = $db->table('tb_artikel');
        $builder->select('tb_artikel.*, tb_users.nama as nama_user');
        $builder->join('tb_users', 'tb_users.id_user = tb_artikel.id_user');
        $builder->where('tb_artikel.id_artikel', $id);
        $query = $builder->get();
        $data = $query->getRowArray();

        if (!$data) {
            return $this->fail('Data tidak ditemukan');
        }

        return $this->respond($data);
    }

    public function create()
    {
        $data = [
            'id_user'     => $this->request->getPost('id_user'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
        ];

        log_message('debug', 'Data dari request: ' . json_encode($data));

        // Handle upload gambar
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
            // Ambil ID artikel yang baru dibuat
            $idArtikel = $this->model->getInsertID();

            // Ambil semua user
            $userModel = new \App\Models\UserModel(); // pastikan model UserModel ada
            $users = $userModel->findAll();

            // Kirim notifikasi ke semua user
            $notifModel = new \App\Models\NotifikasiModel();
            foreach ($users as $user) {
                $notifModel->save([
                    'id_user'   => $user->id_user, // pastikan kolom ini ada
                    'id_artikel' => $idArtikel,
                    'judul'     => 'Artikel Baru!',
                    'pesan'     => 'Ada artikel baru berjudul "' . $data['judul'] . '"',
                    'dibaca'    => '0',
                    'created_at'=> date('Y-m-d H:i:s')
                ]);
            }

            return $this->respondCreated([
                'status' => 201,
                'message' => 'Artikel berhasil disimpan dan notifikasi dikirim ke semua user.',
                'data' => $data
            ]);
        }

        return $this->failServerError('Gagal menyimpan artikel.');
    }



    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

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

    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        if (!$keyword) {
            return $this->failValidationError('Keyword diperlukan');
        }

        $artikelModel = new ArtikelModel();

        // Mencari judul atau isi artikel yang mengandung keyword
        $results = $artikelModel
            ->like('judul', $keyword)
            ->orLike('isi', $keyword)
            ->findAll();

        return $this->respond($results);
    }

    public function tambahDilihat($id)
    {
        $model = new \App\Models\ArtikelModel();
        $artikel = $model->find($id);

        if (!$artikel) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Artikel tidak ditemukan']);
        }

        // Ambil nilai dilihat dari object Entity
        $dilihatSekarang = $artikel->dilihat ?? 0;
        $dilihatBaru = $dilihatSekarang + 1;

        // Pakai query builder untuk memaksa update
        $db = \Config\Database::connect();
        $db->table('tb_artikel')->where('id_artikel', $id)->update(['dilihat' => $dilihatBaru]);

        return $this->response->setJSON([
            'message' => 'Berhasil menambah dilihat',
            'dilihat' => $dilihatBaru
        ]);
    }

    public function byKategori($id_kategori)
    {
        $artikel = $this->model->where('id_kategori', $id_kategori)->findAll();

        if ($artikel) {
            return $this->respond($artikel);
        } else {
            return $this->failNotFound('Tidak ada artikel untuk kategori ini.');
        }
    }

    public function simpan()
{
    // Simpan artikel
    $artikelModel = new \App\Models\ArtikelModel();
    $data = [
        'judul' => $this->request->getPost('judul'),
        'konten' => $this->request->getPost('konten'),
        'created_at' => date('Y-m-d H:i:s')
    ];
    $artikelModel->insert($data);

    // Ambil semua user
    $userModel = new UserModel();
    $users = $userModel->findAll();

    // Kirim notifikasi ke semua user
    $notifikasiModel = new NotifikasiModel();
    foreach ($users as $user) {
        $notifikasiModel->insert([
            'id_user' => $user['id_user'],
            'judul' => 'Artikel Baru!',
            'pesan' => 'Ada artikel baru: ' . $data['judul'],
            'dibaca' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    return redirect()->to('/admin/artikel')->with('success', 'Artikel dan notifikasi berhasil ditambahkan.');
}
}
