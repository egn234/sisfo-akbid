<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_posting;

class Dashboard extends BaseController
{
    public function index()
    {
        $m_user = new M_user();
        $m_posting = new M_posting();

        $account = $m_user->getAccount(session()->get('user_id'));
        $batas = 3;
        $posting_limit = $m_posting->select('*')
            ->limit($batas, 0)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
        $data = [
			'title' => 'Dashboard',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
            'posting_limit' => $posting_limit

        ];
        return view('dosen/dashboard', $data);
    }
}
