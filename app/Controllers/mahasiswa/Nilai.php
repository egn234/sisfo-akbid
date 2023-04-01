<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

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

        return view('mahasiswa/nilai/list-nilai', $data);
    }

    // ? Load data into json
    public function data_nilai()
    {
        $m_user = new M_user();
        $m_nilai = new M_nilai();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_nilai = $m_nilai->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Nilai',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_nilai' => $list_nilai
        ];

        return json_encode($data);
    }

    public function data_periode()
    {
        $m_user = new M_user();
        $m_tahunajaran = new M_tahunajaran();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_tahunajaran = $m_tahunajaran->select('*')
            ->get()
            ->getResult();
        $data = [
            'title'     => 'Daftar Tahun Ajaran',
            'usertype'  => 'Admin',
            'duser'     => $account,
            'list_tahunajaran' => $list_tahunajaran
        ];

        return json_encode($data);
    }
    
}
