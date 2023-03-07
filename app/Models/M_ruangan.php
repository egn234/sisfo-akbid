<?php

namespace App\Models;

use CodeIgniter\Model;

class M_ruangan extends Model
{
    protected $table      = 'tb_ruangan';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'kodeRuangan',
      'namaRuangan',
      'deskripsi'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>