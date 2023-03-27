<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_posting;

class Posting extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $m_posting = new M_posting();
        $account = $m_user->getAccount(session()->get('user_id'));

        $batas = 2;
        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
        $list_posting = $m_posting->select('*')
            ->get()
            ->getResult();
        $jumlah_data = count($list_posting);
        $total_halaman = ceil($jumlah_data / $batas);

        $posting_limit = $m_posting->select('*')
            ->limit($batas, $halaman_awal)
            ->get()
            ->getResult();

        $data = [
            'title' => 'Lihat Posting',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'halaman' => $halaman,
            'total_halaman' => $total_halaman,
            'posting_limit' => $posting_limit
        ];

        return view('mahasiswa/posting/list-posting', $data);
    }

    // ? Load data into json
    public function data_posting()
    {
        $m_user = new M_user();
        $m_posting = new M_posting();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_posting = $m_posting->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Lihat Posting',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_posting' => $list_posting
        ];

        return json_encode($data);
    }

    public function detail_posting($id = false)
    {
        $m_user = new M_user();
        $m_posting = new M_posting();
        $account = $m_user->getAccount(session()->get('user_id'));
        $list_posting = $m_posting->select('*')
            ->where('id',$id)
            ->get()
            ->getResult();

        $data = [
            'title' => 'Lihat Posting',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_posting' => $list_posting
        ];
        return view('mahasiswa/posting/detail-posting', $data);
    }
}
