<?php

namespace App\Models;

use CodeIgniter\Model;

class M_pertanyaan extends Model
{
    protected $table      = 'tb_pertanyaan';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'pertanyaan',
      'jenis_pertanyaan',
      'flag'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>