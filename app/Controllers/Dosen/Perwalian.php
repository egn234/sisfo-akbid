<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;
use App\Models\M_rel_dsn_kls;

class Perwalian extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Kelola Indeks Nilai',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
        ];
        return view('dosen/perwalian/list-kelas', $data);
    }

    public function data_kelas()
    {
        $m_user = new M_user();
        $m_dosen = new M_dosen();
        $m_rel_dsn_kls = new M_rel_dsn_kls();
        
        $account = $m_user->getAccount(session()->get('user_id'));
        $dosen_id = $m_dosen->where('userID', $account->user_id)->get()->getResult()[0]->id;

        $list_kelas = $m_rel_dsn_kls->getKelasDoswal($dosen_id);
        $data = [
            'title' => 'Daftar Kordinator Mata Kuliah',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_kelas' => $list_kelas
        ];

        return json_encode($data);
    }

    public function add_proc()
    {
        # code...
    }
}
