<?php

namespace App\Controllers;

use App\Models\MProduk;

class ProdukController extends RestfulController
{
    public function create()
    {
        $json = $this->request->getJSON();

        $data = [
            'kode_produk' => $json->kode_produk ?? null,
            'nama_produk' => $json->nama_produk ?? null,
            'harga'       => $json->harga ?? null,
        ];

        $model = new MProduk();
        $model->insert($data);
        $produk = $model->find($model->getInsertID());

        return $this->responseHasil(200, true, $produk);
    }

    public function list()
    {
        $model = new MProduk();
        $keyword = $this->request->getGet('keyword');
        $perPage = 10; 

        if (!empty($keyword)) {
            $model->like('nama_produk', $keyword);
        }
        
        $produk = $model->paginate($perPage);

        return $this->responseHasil(200, true, $produk);
    }

    public function detail($id)
    {
        $model = new MProduk();
        $produk = $model->find($id);

        if (!$produk) {
            return $this->responseHasil(404, false, 'Produk tidak ditemukan');
        }

        return $this->responseHasil(200, true, $produk);
    }

    public function ubah($id)
    {
        $json = $this->request->getJSON();

        $data = [
            'kode_produk' => $json->kode_produk ?? null,
            'nama_produk' => $json->nama_produk ?? null,
            'harga'       => $json->harga ?? null,
        ];

        $model = new MProduk();
        $model->update($id, $data);
        $produk = $model->find($id);

        return $this->responseHasil(200, true, $produk);
    }

    public function hapus($id)
    {
        $model = new MProduk();
        $produk = $model->find($id);

        if (!$produk) {
            return $this->responseHasil(404, false, 'Data gagal dihapus, produk tidak ditemukan');
        }

        $model->delete($id);
        return $this->responseHasil(200, true, 'Produk berhasil dihapus');
    }
}