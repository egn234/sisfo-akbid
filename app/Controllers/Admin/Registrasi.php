<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kelas;
use App\Models\M_rel_mhs_jad;

class Registrasi extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Kelola Registrasi Matkul',
			'usertype' => session()->get('user_type'),
			'duser' => $account
        ];

        return view('admin/regis/list-kelas', $data);
    }

    public function detail($id = false)
    {
        $m_user = new M_user();
        $m_kelas = new M_kelas();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Kelola Registrasi Matkul',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
            'kelas_id' => $id
        ];

        return view('admin/regis/list-mhs', $data);
    }

    public function acc_regis($id = false)
    {
        $m_rel_mhs_jad = new M_rel_mhs_jad();

        $m_rel_mhs_jad->approveRegis($id);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Request berhasil di approve',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function reset($id = false)
    {
        $m_rel_mhs_jad = new M_rel_mhs_jad();

        $m_rel_mhs_jad->resetRegis($id);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Request di reset',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function data_kelas()
    {
        $m_user = new M_user();
        $m_kelas = new M_kelas();
        
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_kelas = $m_kelas->getAllKelasRegis();
        $data = [
            'list_kelas' => $list_kelas
        ];

        return json_encode($data);
    }

    public function data_mhs($id = false)
    {
        $m_user = new M_user();
        $m_kelas = new M_kelas();
        
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_mhs = $m_kelas->getAllMhsRegis($id);
        $data = [
            'list_mhs' => $list_mhs
        ];

        return json_encode($data);
    }

    public function data_jadwal($id = false)
	{
		$m_user = new M_user();
        $m_rel_mhs_jad = new M_rel_mhs_jad();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_jadwal = $m_rel_mhs_jad->getAllRegisMhs($id);
        $data = [
            'list_jadwal' => $list_jadwal
        ];

        echo json_encode($list_jadwal);
	}
}
