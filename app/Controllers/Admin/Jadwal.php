<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_jadwal;
use App\Models\M_user;

class Jadwal extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

		$account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Daftar Jadwal',
			'usertype' => 'Admin',
			'duser' => $account
		];

		return view('admin/jadwal/list-jadwal', $data);
    }

	public function data_jadwal()
	{
		$m_user = new M_user();
        $m_jadwal = new M_jadwal();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_jadwal = $m_jadwal->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Jadwal',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_jadwal' => $list_jadwal
        ];

        return json_encode($data);
	}
}