<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function getBerita()
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $terkini = $artikelModel->getTerkini();
        $trending = $artikelModel->getTrending();
        $kategori = $kategoriModel->findAll();

        return $this->response->setJSON([
            'terkini' => $terkini,
            'trending' => $trending,
            'kategori' => $kategori
        ]);
    }
}
