<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tahunajaran extends Model
{
    protected $table      = 'tb_periode';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'tahunPeriode',
      'semester',
      'deskripsi',
      'flag'      
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
