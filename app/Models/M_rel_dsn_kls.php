<?php

namespace App\Models;

use CodeIgniter\Model;

class M_rel_dsn_kls extends Model
{
    protected $table      = 'rel_dsn_kls';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'dosenID',
      'kelasID',
      'flag'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}
?>