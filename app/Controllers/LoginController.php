<?php

namespace App\Controllers;

use App\Models\MLogin;
use App\Models\MMember;

class LoginController extends RestfulController
{
    public function login()
    {
        $json = $this->request->getJSON();
       
        $email    = $json->email ?? null;
        $password = $json->password ?? null;

        if (empty($email) || empty($password)) {
            return $this->responseHasil(400, false, 'Email dan password wajib diisi');
        }

        $model = new MMember();
        $member = $model->where(['email' => $email])->first();

        if (!$member) {
            return $this->responseHasil(400, false, 'Email tidak ditemukan');
        }

        if (!password_verify($password, $member['password'])) {
            return $this->responseHasil(400, false, 'Password tidak valid');
        }

        $login = new MLogin();
        $auth_key = $this->RandomString();

        $login->save([
            'member_id' => $member['id'],
            'auth_key'  => $auth_key,
        ]);

        $data = [
            'token' => $auth_key,
            'user' => [
                'id'    => $member['id'],
                'email' => $member['email'],
            ],
        ];

        return $this->responseHasil(200, true, $data);
    }

    private function RandomString($length = 100)
    {
        $karakter = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $panjang_karakter = strlen($karakter);
        $str = '';

        for ($i = 0; $i < $length; $i++) {
            $str .= $karakter[rand(0, $panjang_karakter - 1)];
        }

        return $str;
    }

    public function getProfil($id = null)
    {
        $model = new MMember();
        $member = $model->find($id);

        if (!$member) {
            return $this->responseHasil(404, false, 'Data member tidak ditemukan');
        }

        unset($member['password']);

        return $this->responseHasil(200, true, $member);
    }
}