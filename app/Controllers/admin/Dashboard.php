<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;

class Dashboard extends BaseController
{
    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->where('id', session()->get('user_id'))->first();
        
        $data = [
			'title' => 'Dashboard',
			'usertype' => 'Admin',
			'duser' => $account
        ];
        return view('admin/dashboard', $data);
    }
}
