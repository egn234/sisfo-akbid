<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_mahasiswa;

class Mahasiswa extends BaseController
{
	
    public function index()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        // $account = $m_user->where('id', session()->get('user_id'))->first();
        $account = $m_user->getAccount(session()->get('user_id'));
        
        $list_mhs = $m_mahasiswa->select('tb_mahasiswa.*, tb_user.username AS username, tb_user.id AS user_id, flag')
                                ->join('tb_user', 'tb_user.id = tb_mahasiswa.userID')
                                ->orderBy('tb_mahasiswa.created_at', 'DESC')
                                ->get()
                                ->getResult();
        $data = [
			'title' => 'Daftar Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account,
            'list_mhs' => $list_mhs
        ];

        return view('admin/mhs/list-mahasiswa', $data);
    }

	public function data_mhs()
	{
		$m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        // $account = $m_user->where('id', session()->get('user_id'))->first();
        $account = $m_user->getAccount(session()->get('user_id'));
        
        $list_mhs = $m_mahasiswa->select('tb_mahasiswa.*, tb_user.username AS username, tb_user.id AS user_id, flag')
                                ->join('tb_user', 'tb_user.id = tb_mahasiswa.userID')
                                ->orderBy('tb_mahasiswa.created_at', 'DESC')
                                ->get()
                                ->getResult();
        $data = [
			'title' => 'Daftar Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account,
            'list_mhs' => $list_mhs
        ];

		return json_encode($data);
	}


    public function add_mhs()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Tambah Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account
		];

		return view('admin/mhs/add-mhs', $data);
    }

	public function flag_switch($user_id = false)
	{
        $m_user = new M_user();
		$user = $m_user->where('id', $user_id)->first();

		if ($user['flag'] == 0) {
			$m_user->where('id', $user_id)->set('flag', '1')->update();
			$alert = view('partials/notification-alert', 
				[
					'notif_text' => 'User Diaktifkan',
				 	'status' => 'success'
				]
			);
			
			session()->setFlashdata('notif', $alert);

		}elseif ($user['flag'] == 1) {
			$m_user->where('id', $user_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'User Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}

		return redirect()->back();
	}

	public function konfirSwitch()
	{
        $m_user = new M_user();

		if ($_POST['rowid']) {
			$id = $_POST['rowid'];
			$user = $m_user->where('id', $id)->first();
			$data = ['a' => $user];
			echo view('admin/mhs/part-mhs-mod-switch', $data);
		}
	}
}
