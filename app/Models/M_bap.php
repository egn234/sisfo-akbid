<?php

namespace App\Models;

use CodeIgniter\Model;

class M_bap extends Model
{
    protected $table      = 'tb_bap';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'mingguPertemuan',
      'materiPertemuan',
      'jadwalID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>