<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

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
}