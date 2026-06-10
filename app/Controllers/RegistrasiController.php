<?php

namespace App\Controllers;

use App\Models\MMember; 

class RegistrasiController extends RestfulController
{
    public function registrasi()
    {
        $json = $this->request->getJSON();

        if (empty($json->nama) || empty($json->email) || empty($json->password)) {
            return $this->responseHasil(400, false, 'Seluruh kolom pendaftaran wajib diisi');
        }

        $data = [
            'nama'     => $json->nama,
            'email'    => $json->email,
            'password' => password_hash($json->password, PASSWORD_DEFAULT),
        ];

        // Disamakan menggunakan MMember() atau MRegistrasi() tergantung penamaan berkas model akun Anda
        $model = new MMember();
        $model->save($data);

        return $this->responseHasil(200, true, 'Registrasi Berhasil');
    }
}