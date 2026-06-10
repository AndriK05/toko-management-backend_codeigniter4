<?php

namespace App\Models;

use CodeIgniter\Model;

class MNote extends Model
{
    protected $table            = 'note';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true; // Memastikan ID digenerate otomatis oleh MySQL
    protected $returnType       = 'array';
    protected $allowedFields    = ['member_id', 'isi_note', 'time'];
}