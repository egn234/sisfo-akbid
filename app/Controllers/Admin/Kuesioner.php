<?php

namespace App\Controllers\Admin;

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
            'title' => 'Daftar Kuesioner',
            'usertype' => 'Admin',
            'duser' => $account
        ];

        return view('admin/kuesioner/list-kuesioner', $data);
    }

    // ? Load data into json
    public function data_kuesioner()
    {
        $m_user = new M_user();
        $m_kuesioner = new M_kuesioner();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_kuesioner = $m_kuesioner->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Kuesioner',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_kuesioner' => $list_kuesioner
        ];

        return json_encode($data);
    }

    public function detail($id = false)
	{
		$m_user = new M_user();
		$m_kuesioner = new M_kuesioner();
		$account = $m_user->getAccount(session()->get('user_id'));

		$detail_kuesioner = $m_kuesioner->where('id', $id)
			->get()->getResult()[0];

		$data = [
			'title' => 'Detail Kuesioner '. $detail_kuesioner->judul_kuesioner,
			'usertype' => 'Admin',
			'duser' => $account,
			'detail_kuesioner' => $detail_kuesioner
		];

		return view('admin/kuesioner/detail-kuesioner', $data);
	}

    public function data_pertanyaan($id)
    {
        $m_user = new M_user();
        $m_pertanyaan = new M_pertanyaan();
        $account = $m_user->getAccount(session()->get('user_id'));
        $list_pertanyaan = $m_pertanyaan->select('*')->where('kuesionerID', $id)
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

    public function process_input()
    {
        $m_kuesioner = new M_kuesioner();

        $judul_kuesioner = $this->request->getPost('judul_kuesioner');

        $data = [
            'judul_kuesioner' => $judul_kuesioner
        ];
        
        $m_kuesioner->insert($data);

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Kuesioner berhasil dibuat',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function process_delete()
    {
        $m_kuesioner = new M_kuesioner();
        $id = $this->request->getPost('idDel');
        $check = $m_kuesioner->delete(array('id ' => $id));
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Berhasil Dihapus',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kuesioner');
    }

    public function process_update()
    {
        $m_kuesioner = new M_kuesioner();
        $id = $this->request->getPost('idPut');

        $judul_kuesioner = $this->request->getPost('judul_kuesioner');

        $data = [
            'judul_kuesioner' => $judul_kuesioner
        ];
        
        $m_kuesioner->set($data)->where('id', $id)->update();

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Kuesioner berhasil dibuat',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kuesioner'); 
    }

    public function flag_switch()
    {
		$m_kuesioner = new M_kuesioner();
		$kuesioner_id = $this->request->getPost('kuesioner_id');
		$kuesioner = $m_kuesioner->where('id', $kuesioner_id)->first();

		if ($kuesioner['flag'] == 0) {
			$m_kuesioner->where('id', $kuesioner_id)->set('flag', 1)->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kuesioner Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($kuesioner['flag'] == 1) {
			$m_kuesioner->where('id', $kuesioner_id)->set('flag', 0)->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kuesioner Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
    }
}
