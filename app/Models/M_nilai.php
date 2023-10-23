<?php

namespace App\Models;

use CodeIgniter\Model;

class M_nilai extends Model
{
  protected $table      = 'tb_nilai_matkul';
  protected $primaryKey = 'id';
  
  protected $allowedFields = [
    'nilaiUTS',
    'nilaiUAS',
    'nilaiPraktek',
    'nilaiTugas',
    'nilaiKehadiran',
    'nilaiAkhir',
    'indeksNilai',
    'matakuliahID',
    'mahasiswaID'
  ];

  protected $returnType = 'array';

  // Dates
  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  function getIndeksNilaiMhs($id = false)
  {
    $sql = "
      SELECT
        a.id, a.nim, a.nama,
        c.matakuliahID,
        d.kodeDosen, d.nip, d.nama,
        e.kodeMatkul, e.namaMatkul, e.sks, e.tingkat, e.semester,
        f.kodeRuangan, f.namaRuangan,
        g.tahunPeriode, g.flag as status_periode,
        IFNULL((SELECT h.nilaiUTS FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiUTS,
        IFNULL((SELECT h.nilaiUAS FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiUAS,
        IFNULL((SELECT h.nilaiPraktek FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiPraktek,
        IFNULL((SELECT h.nilaiTugas FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiTugas,
        IFNULL((SELECT h.nilaiKehadiran FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiKehadiran,
        IFNULL((SELECT h.nilaiAkhir FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiAkhir,
        IFNULL((SELECT h.indeksNilai FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), '-') AS indeksNilai
      FROM tb_mahasiswa a
        JOIN rel_mhs_jad b ON a.id = b.mahasiswaID
        JOIN tb_jadwal c ON b.jadwalID = c.id
        JOIN tb_dosen d ON c.dosenID = d.id
        JOIN tb_matakuliah e ON c.matakuliahID = e.id
        JOIN tb_ruangan f ON c.ruanganID = f.id
        JOIN tb_periode g on c.periodeID = g.id
      WHERE a.id = $id
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }

  function getAllINM($id = false)
  {
    $sql = "
      SELECT
        e.kodeMatkul, e.namaMatkul, e.sks, e.tingkat, e.semester,
        e.id as matakuliahID,
        IFNULL((SELECT h.nilaiUTS FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), 0) AS nilaiUTS,
        IFNULL((SELECT h.nilaiUAS FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), 0) AS nilaiUAS,
        IFNULL((SELECT h.nilaiPraktek FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), 0) AS nilaiPraktek,
        IFNULL((SELECT h.nilaiTugas FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), 0) AS nilaiTugas,
        IFNULL((SELECT h.nilaiKehadiran FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), 0) AS nilaiKehadiran,
        IFNULL((SELECT h.nilaiAkhir FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), 0) AS nilaiAkhir,
        IFNULL((SELECT h.indeksNilai FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = $id), '-') AS indeksNilai
      FROM tb_matakuliah e
      where e.prodiID = (select z.prodiID from tb_mahasiswa z where z.id = $id)
    ";
    
    $db = db_connect();
    return $db->query($sql)->getResult();
  }

  function getIndeksNilaiMhsNow($id)
  {
    $sql = "
      SELECT
        a.nim, a.nama,
        e.kodeMatkul, e.namaMatkul, e.sks, e.tingkat, e.semester,
        g.tahunPeriode, g.flag as status_periode,
        IFNULL((SELECT h.nilaiUTS FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiUTS,
        IFNULL((SELECT h.nilaiUAS FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiUAS,
        IFNULL((SELECT h.nilaiPraktek FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiPraktek,
        IFNULL((SELECT h.nilaiTugas FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiTugas,
        IFNULL((SELECT h.nilaiKehadiran FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiKehadiran,
        IFNULL((SELECT h.nilaiAkhir FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiAkhir,
        IFNULL((SELECT h.indeksNilai FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), '-') AS indeksNilai
      FROM tb_mahasiswa a
        JOIN rel_mhs_jad b ON a.id = b.mahasiswaID
        JOIN tb_jadwal c ON b.jadwalID = c.id
        JOIN tb_matakuliah e ON c.matakuliahID = e.id
        JOIN tb_periode g on c.periodeID = g.id
      WHERE a.id = $id
      AND e.prodiID = (select z.prodiID from tb_mahasiswa z where z.id = $id)
      AND g.flag = 1
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }

  function getAllKHS($mhs_id = false){
    $sql = "
      SELECT
        id, kodeMatkul, namaMatkul, sks, tingkat, semester, tahunPeriode, nilaiAkhir, indeksNilai,
        ROW_NUMBER() OVER (ORDER BY id) as mhs_sem
      FROM (
        SELECT
          e.kodeMatkul, e.namaMatkul, e.sks, e.tingkat, e.semester,
          g.tahunPeriode, g.flag as status_periode, g.id,
          IFNULL((SELECT h.nilaiAkhir FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiAkhir,
          IFNULL((SELECT h.indeksNilai FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), '-') AS indeksNilai
        FROM tb_mahasiswa a
          JOIN rel_mhs_jad b ON a.id = b.mahasiswaID
          JOIN tb_jadwal c ON b.jadwalID = c.id
          JOIN tb_matakuliah e ON c.matakuliahID = e.id
          JOIN tb_periode g on c.periodeID = g.id
        WHERE a.id = $mhs_id
        ORDER BY g.id ASC
      ) AS subquery
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }

  function getKHSPeriode($mhs_id = false, $periode_id = false){
    $sql = "
      SELECT
        id, kodeMatkul, namaMatkul, sks, tingkat, semester, tahunPeriode, nilaiAkhir, indeksNilai,
        ROW_NUMBER() OVER (ORDER BY id) as mhs_sem
      FROM (
        SELECT
          e.kodeMatkul, e.namaMatkul, e.sks, e.tingkat, e.semester,
          g.tahunPeriode, g.flag as status_periode, g.id,
          IFNULL((SELECT h.nilaiAkhir FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), 0) AS nilaiAkhir,
          IFNULL((SELECT h.indeksNilai FROM tb_nilai_matkul h WHERE h.matakuliahID = e.id AND h.mahasiswaID = a.id), '-') AS indeksNilai
        FROM tb_mahasiswa a
          JOIN rel_mhs_jad b ON a.id = b.mahasiswaID
          JOIN tb_jadwal c ON b.jadwalID = c.id
          JOIN tb_matakuliah e ON c.matakuliahID = e.id
          JOIN tb_periode g on c.periodeID = g.id
        WHERE a.id = $mhs_id
        ORDER BY g.id ASC
      ) AS subquery
      WHERE id = $periode_id
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }
}
?>