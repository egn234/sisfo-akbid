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
          c.sks,
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
    
    function getJadwalRegistrasiMhs($id = false, $prodiID)
    {
      $sql = "
        SELECT 
          a.*,
          b.tahunPeriode,
          b.semester,
          c.kodeMatkul,
          c.namaMatkul,
          c.sks,
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
        WHERE b.flag = 1
          AND c.prodiID = ".$prodiID."
          AND a.id NOT IN (SELECT jadwalID FROM rel_mhs_jad zz WHERE zz.mahasiswaID = ".$id.")
        ORDER BY b.tahunPeriode DESC
      ";

      return $this->db->query($sql)->getResult();
    }

    function getJadwalSelectedMhs($id = false)
    {
      $sql = "
        SELECT 
          a.*,
          b.tahunPeriode,
          b.semester,
          c.kodeMatkul,
          c.namaMatkul,
          c.sks,
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
        WHERE b.flag = 1
          AND a.id IN (SELECT jadwalID FROM rel_mhs_jad zz WHERE zz.mahasiswaID = ".$id.")
        ORDER BY b.tahunPeriode DESC
      ";

      return $this->db->query($sql)->getResult();
    }

    function getJadwalDosen($id = false)
    {
      $sql = "
        SELECT
            a.id, a.startTime, a.endTime, a.day,
            b.kodeDosen, b.nama,
            c.kodeMatkul, c.namaMatkul, c.tingkat, c.sks,
            d.kodeRuangan, d.namaRuangan,
            e.tahunPeriode, e.semester
        FROM tb_jadwal a
            JOIN tb_dosen b ON a.dosenID = b.id
            JOIN tb_matakuliah c ON a.matakuliahID = c.id
            JOIN tb_ruangan d ON a.ruanganID = d.id
            JOIN tb_periode e ON a.periodeID = e.id
        WHERE a.dosenID = $id
          AND e.flag = 1
      ";

      return $this->db->query($sql)->getResult();
    }

    function getJadwalDosenNilai($id = false)
    {
      $sql = "
        SELECT
            a.id, a.startTime, a.endTime, a.day,
            b.kodeDosen, b.nama,
            c.kodeMatkul, c.namaMatkul, c.tingkat, c.sks,
            d.kodeRuangan, d.namaRuangan,
            e.tahunPeriode, e.semester
        FROM tb_jadwal a
            JOIN tb_dosen b ON a.dosenID = b.id
            JOIN tb_matakuliah c ON a.matakuliahID = c.id
            JOIN tb_ruangan d ON a.ruanganID = d.id
            JOIN tb_periode e ON a.periodeID = e.id
        WHERE a.id = $id
          AND e.flag = 1
      ";

      return $this->db->query($sql)->getResult();
    }
  }
?>