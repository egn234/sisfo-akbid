<?php

namespace App\Models;

use CodeIgniter\Model;

class M_prodi extends Model
{
    protected $table      = 'tb_prodi';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'strata',
      'nama_prodi',
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