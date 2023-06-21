<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;
use App\Models\M_bap;
use App\Models\M_jadwal;

class Bap extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));
        
        $data = [
			'title' => 'Kelola BAP',
			'usertype' => session()->get('user_type'),
			'duser' => $account
        ];
        
        return view('dosen/bap/matkul-list', $data);
    }

    function list_bap($id = false)
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));
        
        $data = [
			'title' => 'Kelola BAP',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
            'jadwal_id' => $id
        ];
        
        return view('dosen/bap/bap-list', $data);
    }

    public function data_matkul()
    {
        $m_user = new M_user();
        $m_dosen = new M_dosen();
        $m_jadwal = new M_jadwal();

        $id = $m_dosen->where('userID', session()->get('user_id'))->get()->getResult()[0]->id;

        $list_matkul = $m_jadwal->getJadwalDosen($id);

        $data = [
            'data' => $list_matkul
        ];

        return json_encode($data);        
    }

    public function data_bap($jadwal_id = false)
    {
        $m_user = new M_user();
        $m_dosen = new M_dosen();
        $m_bap = new M_bap();

        $id = $m_dosen->where('userID', session()->get('user_id'))->get()->getResult()[0]->id;

        $list_bap = $m_bap->getBapDosen($id, $jadwal_id);

        $data = [
            'data' => $list_bap
        ];

        return json_encode($data);
    }
}
