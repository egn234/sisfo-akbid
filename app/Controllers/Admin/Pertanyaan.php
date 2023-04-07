<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_pertanyaan;

class Pertanyaan extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Daftar Pertanyaan',
            'usertype' => 'Admin',
            'duser' => $account
        ];

        return view('admin/pertanyaan/list-pertanyaan', $data);
    }

    // ? Load data into json
    public function data_pertanyaan()
    {
        $m_user = new M_user();
        $m_pertanyaan = new M_pertanyaan();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_pertanyaan = $m_pertanyaan->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Pertanyaan',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_pertanyaan' => $list_pertanyaan
        ];

        return json_encode($data);
    }

    public function process_input()
    {
        $m_pertanyaan = new M_pertanyaan();

        $pertanyaan = $this->request->getPost('pertanyaan');
        $jenis_pertanyaan = $this->request->getPost('jenis_pertanyaan');
        $kuesionerID = $this->request->getPost('kuesionerID');

        if ($jenis_pertanyaan == '') {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Belum memilih jenis pertanyaan',
                    'status' => 'warning'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();            
        }

        $data = [
            'pertanyaan' => $pertanyaan,
            'jenis_pertanyaan' => $jenis_pertanyaan,
            'kuesionerID' => $kuesionerID
        ];

        $m_pertanyaan->insert($data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Pertanyaan berhasil ditambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function process_delete()
    {
        $m_pertanyaan = new M_pertanyaan();
        $id = $this->request->getPost('idDel');
        $check = $m_pertanyaan->delete(array('id ' => $id));
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Berhasil Dihapus',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function process_update()
    {
    	$m_pertanyaan = new M_pertanyaan();
    	$id = $this->request->getPost('idPut');

        $pertanyaan = $this->request->getPost('pertanyaan');
        $jenis_pertanyaan = $this->request->getPost('jenis_pertanyaan');

        if ($jenis_pertanyaan == '') {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Belum memilih jenis pertanyaan',
                    'status' => 'warning'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();            
        }

        $data = [
            'pertanyaan' => $pertanyaan,
            'jenis_pertanyaan' => $jenis_pertanyaan
        ];

        $m_pertanyaan->set($data)->where('id', $id)->update();
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Pertanyaan berhasil diubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function flag_switch()
    {
		$m_pertanyaan = new M_pertanyaan();
		$pertanyaan_id = $this->request->getPost('pertanyaan_id');
		$pertanyaan = $m_pertanyaan->where('id', $pertanyaan_id)->first();

		if ($pertanyaan['flag'] == 0) {
			$m_pertanyaan->where('id', $pertanyaan_id)->set('flag', 1)->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Pertanyaan Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($pertanyaan['flag'] == 1) {
			$m_pertanyaan->where('id', $pertanyaan_id)->set('flag', 0)->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Pertanyaan Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
    }

}
