<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\M_mahasiswa;
use App\Models\M_user;
use App\Models\M_nilai;
use App\Models\M_tahunajaran;


class Nilai extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Nilai',
            'usertype' => session()->get('userType'),
            'duser' => $account
        ];

        return view('mahasiswa/nilai/nilai-list', $data);
    }

    public function data_nilai()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_nilai = new M_nilai();
        
        $mhs_id = $m_mahasiswa->where("userID", session()->get('user_id'))
            ->get()->getResult()[0]->id;
        
        $data_nilai = $m_nilai->getIndeksNilaiMhs($mhs_id);

        $data = ['data' => $data_nilai];

        return json_encode($data);
    }
    
}
