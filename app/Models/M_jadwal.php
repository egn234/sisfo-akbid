<?php

namespace App\Models;

use CodeIgniter\Model;

class M_jadwal extends Model
{
    protected $table      = 'tb_jadwal';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'startTime',
      'endTime',
      'day',
      'deskripsi',
      'flag',
      'matakuliahID',
      'dosenID',
      'ruanganID',
      'periodeID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>