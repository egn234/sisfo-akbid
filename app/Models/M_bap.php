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

    function getBapDosen($id = false, $jadwal_id = false)
    {
      $sql = "
        SELECT 
          a.*,
            b.startTime, b.endTime, b.day,
            c.kodeDosen, c.nama,
            d.kodeMatkul, d.namaMatkul, d.tingkat, d.sks,
            e.kodeRuangan, e.namaRuangan,
            f.tahunPeriode, f.semester,
            (SELECT COUNT(g.id) FROM tb_kehadiran g WHERE g.bapID = a.id) AS data_hadir
        FROM tb_bap a
          JOIN tb_jadwal b ON a.jadwalID = b.id
            JOIN tb_dosen c ON b.dosenID = c.id
            JOIN tb_matakuliah d ON b.matakuliahID = d.id
            JOIN tb_ruangan e ON b.ruanganID = e.id
            JOIN tb_periode f ON b.periodeID = f.id
        WHERE b.dosenID = $id
          AND b.id = $jadwal_id
          AND f.flag = 1
      ";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }

    function getDetailBapDosen($id = false)
    {
      $sql = "
        SELECT 
          a.*,
          b.startTime, b.endTime, b.day,
          c.kodeDosen, c.nama, c.nip,
          d.kodeMatkul, d.namaMatkul, d.tingkat, d.sks,
          e.kodeRuangan, e.namaRuangan,
          f.tahunPeriode, f.semester,
          (SELECT COUNT(g.id) FROM tb_kehadiran g WHERE g.bapID = a.id) AS data_hadir
        FROM tb_bap a
          JOIN tb_jadwal b ON a.jadwalID = b.id
          JOIN tb_dosen c ON b.dosenID = c.id
          JOIN tb_matakuliah d ON b.matakuliahID = d.id
          JOIN tb_ruangan e ON b.ruanganID = e.id
          JOIN tb_periode f ON b.periodeID = f.id
        WHERE a.id = $id;
      ";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }
  }
?>