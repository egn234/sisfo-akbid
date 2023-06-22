<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kehadiran;

class Presensi extends BaseController
{
    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Presensi',
			'usertype' => session()->get('user_type'),
			'duser' => $account

        ];
        return view('mahasiswa/presensi/presensi-detail', $data);
    }

    public function data_presensi($id = false)
    {
        $m_kehadiran = new M_kehadiran();

        $list_jadwal = $m_kehadiran->getPresensiMahasiswa($id);
        $data = ['data' => $list_jadwal];
        return json_encode($data);
    }
}
