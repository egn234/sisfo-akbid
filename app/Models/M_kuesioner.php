<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kuesioner extends Model
{
    protected $table      = 'tb_kuesioner';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'judul_kuesioner',
      'flag'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>