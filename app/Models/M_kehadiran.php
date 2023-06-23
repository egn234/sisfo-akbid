<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kehadiran extends Model
{
    protected $table      = 'tb_kehadiran';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'status',
      'mahasiswaID',
      'bapID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getPresensiMahasiswa($id = false)
    {
      $sql = "
        SELECT 
          b.startTime, b.endTime, b.day, 
          f.kodeMatkul, f.namaMatkul, f.tingkat, f.sks,
          (SELECT COUNT(d.id) FROM tb_bap d
            JOIN tb_kehadiran e ON d.id = e.bapID
            WHERE d.jadwalID = a.jadwalID
            AND e.status = 'hadir'
          ) AS jum_kehadiran,
          (SELECT COUNT(d.id) FROM tb_bap d WHERE d.jadwalID = a.jadwalID) AS jum_perkuliahan
        FROM rel_mhs_jad a
          JOIN tb_jadwal b ON a.jadwalID = b.id
          JOIN tb_periode c ON b.periodeID = c.id
          JOIN tb_matakuliah f ON b.matakuliahID = f.id
        WHERE a.mahasiswaID = $id
          AND c.flag = 1;
      ";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }

    function getSinglePresensi($mhs_id, $matkul_id)
    {
      $sql = "
        SELECT 
          b.startTime, b.endTime, b.day, 
          f.kodeMatkul, f.namaMatkul, f.tingkat, f.sks,
          COALESCE(
            (
              SELECT COUNT(d.id) FROM tb_bap d
              JOIN tb_kehadiran e ON d.id = e.bapID
              WHERE d.jadwalID = a.jadwalID
              AND e.status = 'hadir'
            ), 0
          ) AS jum_kehadiran,
          COALESCE(
            (
              SELECT COUNT(d.id) FROM tb_bap d WHERE d.jadwalID = a.jadwalID
            ), 0
          ) AS jum_perkuliahan,
          ROUND(
            (
              COALESCE(
                (
                  SELECT COUNT(d.id) FROM tb_bap d WHERE d.jadwalID = a.jadwalID
                ), 0
              ) /
              COALESCE(
                (
                  SELECT COUNT(d.id) FROM tb_bap d
                  JOIN tb_kehadiran e ON d.id = e.bapID
                  WHERE d.jadwalID = a.jadwalID
                  AND e.status = 'hadir'
                ), 0
              )
            ), 2
          ) AS ratio
        FROM rel_mhs_jad a
          JOIN tb_jadwal b ON a.jadwalID = b.id
          JOIN tb_periode c ON b.periodeID = c.id
          JOIN tb_matakuliah f ON b.matakuliahID = f.id
        WHERE a.mahasiswaID = $mhs_id
          AND b.matakuliahID = $matkul_id
      ";

      $db = db_connect();
      return $db->query($sql)->getResult()[0];
    }
  }
?>