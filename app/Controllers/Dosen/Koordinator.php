<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_rel_dos_matkul_koor;
use App\Models\M_param_nilai;

class Koordinator extends BaseController
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
        return view('dosen/koor/list-matkul-koor', $data);
    }

    public function koor_data()
    {
        $m_user = new M_user();
        $m_param_nilai = new M_param_nilai();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_matkul = $m_param_nilai->getParamByDosen($account->user_id);
        $data = [
            'title' => 'Daftar Kordinator Mata Kuliah',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_matkul' => $list_matkul
        ];

        return json_encode($data);
    }

    public function add_proc()
    {
        # code...
    }
}
