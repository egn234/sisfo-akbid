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

    function __construct()
    {
      $this->db = db_connect();
    }

    function getAllJadwal()
    {
      $sql = "
        SELECT 
          a.*,
          b.tahunPeriode,
          b.semester,
          c.kodeMatkul,
          c.namaMatkul,
          c.tingkat,
          d.kodeDosen,
          d.nama,
          e.kodeRuangan,
          e.namaRuangan
        FROM tb_jadwal a
          JOIN tb_periode b ON a.periodeID = b.id
          JOIN tb_matakuliah c ON a.matakuliahID = c.id
          JOIN tb_dosen d ON a.dosenID = d.id
          JOIN tb_ruangan e ON a.ruanganID = e.id
        ORDER BY b.tahunPeriode DESC
      ";

      return $this->db->query($sql)->getResult();
    }
}
?>