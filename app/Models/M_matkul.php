<?php

namespace App\Models;

use CodeIgniter\Model;

class M_matkul extends Model
{
    protected $table      = 'tb_matakuliah';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'kodeMatkul',
      'namaMatkul',
      'deskripsi',
      'sks',
      'tingkat',
      'semester',
      'flag',
      'prodiID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>