<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kuesioner;
use App\Models\M_pertanyaan;


class Kuesioner extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Kuesioner',
            'usertype' => session()->get('userType'),
            'duser' => $account
        ];

        return view('mahasiswa/kuesioner/list-kuesioner', $data);
    }

    public function pertanyaan_kuesioner($id = false)
    {
        $m_user = new M_user();
        $m_kuesioner = new M_kuesioner();

        $account = $m_user->getAccount(session()->get('user_id'));
        $list_pertanyaan = $m_kuesioner->select('tb_kuesioner.judul_kuesioner,tb_pertanyaan.*')
            ->join('tb_pertanyaan', 'tb_pertanyaan.kuesionerID = tb_kuesioner.id', 'left')
            ->where('tb_pertanyaan.kuesionerID', $id)
            ->get()
            ->getResult();
        $data = [
            'title' => 'Kuesioner',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_pertanyaan' => $list_pertanyaan

        ];

        return view('mahasiswa/kuesioner/pertanyaan-kuesioner', $data);
    }

    // ? Load data into json
    public function data_kuesioner()
    {
        $m_user = new M_user();
        $m_kuesioner = new M_kuesioner();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_kuesioner = $m_kuesioner->select('tb_kuesioner.*, COUNT( tb_pertanyaan.id) AS jumlah_pertanyaan')
            ->join('tb_pertanyaan', 'tb_pertanyaan.kuesionerID = tb_kuesioner.id', 'left')
            ->where('tb_kuesioner.flag', 1)
            ->groupBy('tb_kuesioner.id')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Kuesioner',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_kuesioner' => $list_kuesioner
        ];

        return json_encode($data);
    }

    public function data_pertanyaan()
    {
        $m_user = new M_user();
        $m_pertanyaan = new M_pertanyaan();
        $account = $m_user->getAccount(session()->get('user_id'));
        $id = $this->request->getPost('id');
        $list_pertanyaan = $m_pertanyaan->select('*')->where(['kuesionerID' => $id])
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Kuesioner',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_pertanyaan' => $list_pertanyaan
        ];

        return json_encode($data);
    }
}
