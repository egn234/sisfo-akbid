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
      'userID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>