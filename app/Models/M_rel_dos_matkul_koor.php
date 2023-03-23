<?php

namespace App\Models;

use CodeIgniter\Model;

class M_rel_dos_matkul_koor extends Model
{
    protected $table      = 'rel_dos_matkul_koor';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'dosenID',
      'matakuliahID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

}
?>