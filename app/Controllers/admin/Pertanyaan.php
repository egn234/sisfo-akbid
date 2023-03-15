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

        $data = array(
            'pertanyaan'       => $this->request->getPost('pertanyaan'),
            'jenis_pertanyaan'       => $this->request->getPost('jenis_pertanyaan'),
            'flag'         => $this->request->getPost('flag'),
        );

        $check = $m_pertanyaan->insert($data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Pertanyaan Berhasil DiTambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/pertanyaan');
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
        return redirect()->to('admin/pertanyaan');
    }

    public function process_update()
    {
    	$m_pertanyaan = new M_pertanyaan();
    	$id = $this->request->getPost('idPut');
    	$data = array(
            'pertanyaan'       => $this->request->getPost('pertanyaan'),
            'jenis_pertanyaan'       => $this->request->getPost('jenis_pertanyaan'),
            'flag'         => $this->request->getPost('flag'),
        );
    	$m_pertanyaan->update(['id' => $id],$data);
    	$alert = view(
    		'partials/notification-alert',
    		[
    			'notif_text' => 'Data Pertanyaan Berhasil Di Ubah',
    			'status' => 'success'
    		]
    	);

    	session()->setFlashdata('notif', $alert);
    	return redirect()->to('admin/pertanyaan');
    }

}
