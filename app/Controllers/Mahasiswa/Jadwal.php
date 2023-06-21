<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_jadwal;
use App\Models\M_mahasiswa;
use App\Models\M_tahunajaran;
use App\Models\M_rel_mhs_jad;

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
        $m_mahasiswa = new M_mahasiswa();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $periodeID = $m_tahunajaran->where('flag', 1)->get()->getResult()[0]->id;
        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $m_rel_mhs_jad = new M_rel_mhs_jad();
        $list_jadwal = $m_rel_mhs_jad->getKSM($periodeID, $mahasiswaID);

        $data = [
            'data' => $list_jadwal
        ];

        return json_encode($data);
    }
    
}
