<?php

namespace App\Models;

use CodeIgniter\Model;

class M_param_nilai extends Model
{
    protected $table      = 'tb_param_nilai';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'paramKehadiran',
      'paramUTS',
      'paramUAS',
      'paramTugas',
      'paramPraktek',
      'koorID'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getParamByDosen($dosen_id)
    {
        $sql = "
            SELECT 
                a.*,
                c.kodeMatkul, c.namaMatkul, c.tingkat, c.sks, c.semester,
                d.kodeDosen, d.nama
            FROM tb_param_nilai a
                JOIN rel_dos_matkul_koor b ON a.koorID = b.id
                JOIN tb_matakuliah c ON b.matakuliahID = c.id
                JOIN tb_dosen d ON b.dosenID = d.id
            WHERE d.userID = ". $dosen_id ."
        ";

        $db = db_connect();
        return $db->query($sql)->getResult();
    }

    function getParamByMatkul($matkul_id)
    {
      $sql = "
        SELECT a.* FROM tb_param_nilai a
        JOIN rel_dos_matkul_koor b ON a.koorID = b.id
        WHERE b.matakuliahID = $matkul_id
      ";

      $db = db_connect();
      return $db->query($sql)->getResult();
    }

}
?>