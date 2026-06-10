<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class RestfulController extends Controller
{
    protected function responseHasil(
        $status = 200,
        $error = null,
        $messages = ''
    ) {
        $response = [
            'status' => $status,
            'error' => $error,
            'messages' => $messages
        ];

        return $this->response
            ->setStatusCode($status)
            ->setJSON($response);
    }
}