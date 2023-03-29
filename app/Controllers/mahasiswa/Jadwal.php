<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_jadwal;

class jadwal extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Jadwal',
            'usertype' => session()->get('userType'),
            'duser' => $account
        ];

        return view('mahasiswa/jadwal/list-jadwal', $data);
    }

    // ? Load data into json
    public function data_jadwal()
    {
        $m_user = new M_user();
        $m_jadwal = new M_jadwal();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_jadwal = $m_jadwal->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Jadwal',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_jadwal' => $list_jadwal
        ];

        return json_encode($data);
    }
    
}
