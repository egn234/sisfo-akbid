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
      'registrasi_awal',
      'registrasi_akhir',
      'deskripsi',
      'flag'      
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function cekMasaRegis()
    {
      $sql = "SELECT COUNT(id) AS hitung FROM tb_periode 
        WHERE flag = 1
        AND (NOW() BETWEEN registrasi_awal AND registrasi_akhir)";
      
      $db = db_connect();
      return $db->query($sql)->getResult();
    }

}
