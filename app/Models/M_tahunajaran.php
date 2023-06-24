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

    public function cekRegis($periode_id = false, $mahasiswaID = false)
    {
      $sql = "SELECT COUNT(a.id) as hitung FROM rel_mhs_jad a 
        JOIN tb_jadwal b ON a.jadwalID = b.id
        WHERE b.periodeID = $periode_id
        AND a.mahasiswaID = $mahasiswaID";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }

    function getPeriodeKHS($id = false)
    {
      $sql = "
        SELECT a.* FROM tb_periode a
          JOIN tb_jadwal b ON a.id = b.periodeID
          JOIN rel_mhs_jad c ON b.id = c.jadwalID
        WHERE c.mahasiswaID = 97
        GROUP BY a.id
      ";
      
      $db = db_connect();
      return $db->query($sql)->getResult();
    }

}
