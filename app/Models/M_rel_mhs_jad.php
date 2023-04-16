<?php

namespace App\Models;

use CodeIgniter\Model;

class M_rel_mhs_jad extends Model
{
    protected $table      = 'rel_mhs_jad';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'status',
      'flag',
      'mahasiswaID',
      'jadwalID'
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

    function getJadwalMhs($id = false)
    {
        $sql = "
            SELECT 
                b.userID,
                f.kodeMatkul, f.namaMatkul, f.tingkat, f.sks,
                c.startTime, c.endTime, c.day,
                e.kodeRuangan, e.namaRuangan,
                d.tahunPeriode, d.semester, d.flag AS periode_flag
            FROM rel_mhs_jad a 
                JOIN tb_mahasiswa b ON a.mahasiswaID = b.id
                JOIN tb_jadwal c ON a.jadwalID = c.id
                JOIN tb_periode d ON c.periodeID = d.id
                JOIN tb_ruangan e ON c.ruanganID = e.id
                JOIN tb_matakuliah f ON c.matakuliahID = f.id
            WHERE b.userID = ". $id ."
                AND d.flag = 1
        ";

        return $this->db->query($sql)->getResult();
    }
}
?>