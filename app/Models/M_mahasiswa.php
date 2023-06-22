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

    function getListMhsBap($id = false)
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
}
?>