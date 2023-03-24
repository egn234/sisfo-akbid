<?php

namespace App\Models;

use CodeIgniter\Model;

class M_jawaban extends Model
{
    protected $table      = 'tb_jawaban';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'jawaban',
      'flag',
      'pertanyaanID',
      'mahasiswaID',
      'periodeID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>