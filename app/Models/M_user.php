<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    protected $table      = 'tb_user';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
      'username',
      'password',
      'flag',
      'userType'
    ];

    protected $returnType = 'array';

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAccount($id = false)
    {
      $db = db_connect();
      $builder = $db->table('tb_user');
      $user = $builder->where('id', $id)->get()->getResult()[0];

      if($user->userType == 'admin'){
        $query = $builder->select('tb_user.id AS user_id, tb_user.username AS username, tb_user.flag as flag, tb_user.userType as userType, tb_admin.*')
          ->where('tb_user.id', $id)->join('tb_admin', 'tb_user.id = tb_admin.userID')->get();
      }
      elseif($user->userType == 'dosen'){
        $query = $builder->select('tb_user.id AS user_id, tb_user.username AS username, tb_user.flag as flag, tb_user.userType as userType, tb_dosen.*')
          ->where('tb_user.id', $id)->join('tb_dosen', 'tb_user.id = tb_dosen.userID')->get();
      }
      else{
        $query = $builder->select('tb_user.id AS user_id, tb_user.username AS username, tb_user.flag as flag, tb_user.userType as userType, tb_mahasiswa.*')
          ->where('tb_user.id', $id)->join('tb_mahasiswa', 'tb_user.id = tb_mahasiswa.userID')->get();
      }
      return $query->getResult()[0];
    }
}
?>