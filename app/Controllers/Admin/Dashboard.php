<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_mahasiswa;
use App\Models\M_dosen;
use App\Models\M_kelas;
use App\Models\M_posting;

class Dashboard extends BaseController
{
    public function index()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_dosen = new M_dosen();
        $m_kelas = new M_kelas();
        $m_posting = new M_posting();

        $account = $m_user->getAccount(session()->get('user_id'));
        $list_mhs = $m_mahasiswa->select('tb_mahasiswa.*, tb_user.username AS username, tb_user.id AS user_id, flag')
            ->join('tb_user', 'tb_user.id = tb_mahasiswa.userID')
            ->orderBy('tb_mahasiswa.created_at', 'DESC')
            ->get()
            ->getResult();
        $list_dosen = $m_dosen->select('tb_dosen.*, tb_user.username AS username, tb_user.id AS user_id, flag')
            ->join('tb_user', 'tb_user.id = tb_dosen.userID')
            ->orderBy('tb_dosen.created_at', 'DESC')
            ->get()
            ->getResult();
        $list_kelas = $m_kelas->select('*')
            ->get()
            ->getResult();

        $batas = 3;
        $posting_limit = $m_posting->select('*')
            ->limit($batas, 0)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Dashboard',
            'usertype' => session()->get('user_type'),
            'duser' => $account,
            'total_mhs' => count($list_mhs),
            'total_dosen' => count($list_dosen),
            'total_kelas' => count($list_kelas),
            'posting_limit' => $posting_limit
        ];
        return view('admin/dashboard', $data);
    }

    // public function data_mhs()
    // {
    //     $m_mahasiswa = new M_mahasiswa();
    //     $list_mhs = $m_mahasiswa->select('tb_mahasiswa.*, tb_user.username AS username, tb_user.id AS user_id, flag')
    //         ->join('tb_user', 'tb_user.id = tb_mahasiswa.userID')
    //         ->orderBy('tb_mahasiswa.created_at', 'DESC')
    //         ->get()
    //         ->getResult();
    //     $data = ['total_mhs' => count($list_mhs)];
    // 	return json_encode($data);

    // }
}
