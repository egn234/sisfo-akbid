<?php

namespace App\Models;

use CodeIgniter\Model;

class M_admin extends Model
{
    protected $table      = 'tb_admin';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'nik',
      'nama',
      'jenisKelamin',
      'alamat',
      'email',
      'kontak',
      'foto'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>