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
}
?>