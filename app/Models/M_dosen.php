<?php

namespace App\Models;

use CodeIgniter\Model;

class M_dosen extends Model
{
    protected $table      = 'tb_dosen';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'kodeDosen',
      'nip',
      'nama',
      'jenisKelamin',
      'nik',
      'alamat',
      'email',
      'kontak',
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