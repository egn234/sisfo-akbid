<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kelas extends Model
{
  protected $table      = 'tb_kelas';
  protected $primaryKey = 'id';
  
  protected $allowedFields = [
    'kodeKelas',
    'angkatan',
    'tahunAngkatan',
    'deskripsi',
    'flag'
  ];

  protected $returnType = 'array';

  // Dates
  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  function getAllKelasRegis()
  {
    $sql = "
    SELECT
      a.*,
      (
        SELECT COUNT(a1.id) FROM rel_mhs_jad a1
          JOIN rel_mhs_kls b1 ON a1.mahasiswaID = b1.mahasiswaID
        WHERE a.id = b1.kelasID
      ) AS jum_mhs
      FROM tb_kelas a
      WHERE (
        SELECT COUNT(a1.id) FROM rel_mhs_jad a1
          JOIN rel_mhs_kls b1 ON a1.mahasiswaID = b1.mahasiswaID
        WHERE a.id = b1.kelasID
      ) > 0;
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }

  function getAllMhsRegis($id = false)
  {
    $sql = "
      SELECT 
        b.*, c.kodeKelas, c.angkatan, c.tahunAngkatan
      FROM rel_mhs_kls a
      JOIN tb_mahasiswa b ON a.mahasiswaID = b.id
        JOIN tb_kelas c ON a.kelasID = c.id
      WHERE
        (SELECT COUNT(a1.id) FROM rel_mhs_jad a1 WHERE a1.mahasiswaID = a.mahasiswaID AND a1.status = 'waiting' ) > 0
        AND a.kelasID = $id
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }

  function getMhsKelas()
  {
    $sql = "
      SELECT * FROM tb_mahasiswa a
        WHERE a.statusAkademik = 'aktif'
            AND a.id NOT IN (SELECT id FROM rel_mhs_kls b WHERE a.id = b.id)
        ORDER BY a.created_at DESC
    ";

    $db = db_connect();
    return $db->query($sql)->getResult();
  }
}
?>