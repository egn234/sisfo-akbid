<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kelas extends Model
{
    protected $table      = 'tb_kelas';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'kodeKelas',
      'angkatan',
      'tahunAngkatan',
      'deskripsi',
      'flag'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>