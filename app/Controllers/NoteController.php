<?php

namespace App\Controllers;

use App\Models\MNote;

class NoteController extends RestfulController
{
    public function create()
    {
        $json = $this->request->getJSON();

        $data = [
            'member_id' => $json->member_id ?? 1,
            'isi_note'  => $json->isi_note ?? null,
            'time'      => $json->time ?? null,
        ];

        if (empty($data['isi_note']) || empty($data['time'])) {
            return $this->responseHasil(400, false, 'Data note tidak boleh kosong');
        }

        $model = new MNote();
        $model->insert($data);

        return $this->responseHasil(200, true, 'Catatan berhasil disimpan');
    }

    public function list($member_id = null)
    {
        $model = new \App\Models\MNote();
        // Mencari seluruh catatan yang memiliki member_id sesuai dengan user yang login
        $notes = $model->where('member_id', $member_id)->orderBy('id', 'DESC')->findAll();

        // Mengembalikan data array menggunakan responseHasil bawaan RestfulController Anda
        return $this->responseHasil(200, true, $notes);
    }
}