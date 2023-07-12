<?php

namespace App\Models;

use CodeIgniter\Model;

class M_mahasiswa extends Model
{
    protected $table      = 'tb_mahasiswa';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'nim',
      'nama',
      'jenisKelamin',
      'nik',
      'tempatLahir',
      'tanggalLahir',
      'alamat',
      'email',
      'kontak',
      'namaIbu',
      'kontakIbu',
      'namaAyah',
      'kontakAyah',
      'namaWali',
      'kontakWali',
      'foto',
      'statusAkademik',
      'userID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getListMhsBap($id = false) : array
    {
      $sql = "
        SELECT
          a.id, a.nama, a.nim,
          d.kodeKelas, d.angkatan, d.tahunAngkatan, d.deskripsi
        FROM tb_mahasiswa a
          JOIN rel_mhs_jad b ON a.id = b.mahasiswaID
          JOIN rel_mhs_kls c ON a.id = c.mahasiswaID
          JOIN tb_kelas d ON c.kelasID = d.id
        WHERE b.jadwalID = (SELECT e.jadwalID FROM tb_bap e WHERE e.id = $id);
      ";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }

    function getListMhsNilai($id = false) : array
    {
      $sql = "
        SELECT 
          a.id, a.nama, a.nim,
          e.kodeKelas, e.angkatan, e.tahunAngkatan,
          c.matakuliahID,
          IFNULL((SELECT f.nilaiKehadiran FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS nilaiKehadiran,
          IFNULL((SELECT f.nilaiTugas FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS nilaiTugas,
          IFNULL((SELECT f.nilaiPraktek FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS nilaiPraktek,
          IFNULL((SELECT f.nilaiUTS FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS nilaiUTS,
          IFNULL((SELECT f.nilaiUAS FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS nilaiUAS,
          IFNULL((SELECT f.nilaiAkhir FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS nilaiAkhir,
          IFNULL((SELECT f.indeksNilai FROM tb_nilai_matkul f WHERE f.matakuliahID = c.matakuliahID AND f.mahasiswaID = a.id LIMIT 1), 'NA') AS indeksNilai
        FROM tb_mahasiswa a
          JOIN rel_mhs_jad b ON a.id = b.mahasiswaID
          JOIN tb_jadwal c ON b.jadwalID = c.id
          JOIN rel_mhs_kls d ON a.id = d.mahasiswaID
          JOIN tb_kelas e ON d.kelasID = e.id
        WHERE c.id = $id
      ";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }

    function getMhsKelas($id = false) 
    {
      $sql = "
        SELECT 
          a.id, a.nim, a.nama,
          c.kodeKelas, c.angkatan, c.tahunAngkatan, c.flag
        FROM tb_mahasiswa a
          JOIN rel_mhs_kls b ON a.id = b.mahasiswaID
          JOIN tb_kelas c ON c.id = b.kelasID
        WHERE b.kelasID = $id
      ";
      
      $db = db_connect();
      return $db->query($sql)->getResult();
    }
  }
?>