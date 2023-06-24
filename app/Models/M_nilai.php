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
        a.nim, a.nama,
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
}
?>