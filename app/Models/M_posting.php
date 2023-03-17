<?php

namespace App\Models;

use CodeIgniter\Model;

class M_posting extends Model
{
    protected $table      = 'tb_posting';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'judul',
      'deskripsi',
      'attachment',
      'adminID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>