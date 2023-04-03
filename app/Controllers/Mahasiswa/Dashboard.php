<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;

class Dashboard extends BaseController
{
    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));
        
        $data = [
			'title' => 'Dashboard',
			'usertype' => session()->get('user_type'),
			'duser' => $account
        ];
        return view('mahasiswa/dashboard', $data);
    }
}
