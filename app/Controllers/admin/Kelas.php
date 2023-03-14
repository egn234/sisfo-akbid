<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kelas;

class Kelas extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Daftar Kelas',
            'usertype' => 'Admin',
            'duser' => $account
        ];

        return view('admin/kelas/list-kelas', $data);
    }

    // ? Load data into json
    public function data_kelas()
    {
        $m_user = new M_user();
        $m_kelas = new M_kelas();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_kelas = $m_kelas->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Kelas',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_kelas' => $list_kelas
        ];

        return json_encode($data);
    }

    public function process_input()
    {
        $m_kelas = new M_kelas();

        $data = array(
            'kodeKelas'       => $this->request->getPost('kodeKelas'),
            'angkatan'       => $this->request->getPost('angkatan'),
            'tahunAngkatan'         => $this->request->getPost('tahunAngkatan'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'flag'         => $this->request->getPost('flag'),
        );

        $check = $m_kelas->insert($data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Kelas Berhasil DiTambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kelas');
    }

    public function process_delete()
    {
        $m_kelas = new M_kelas();
        $id = $this->request->getPost('idDel');
        $check = $m_kelas->delete(array('id ' => $id));
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Berhasil Dihapus',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kelas');
    }

    public function process_update()
    {
    	$m_kelas = new M_kelas();
    	$id = $this->request->getPost('idPut');
    	$data = array(
            'kodeKelas'       => $this->request->getPost('kodeKelas'),
            'angkatan'       => $this->request->getPost('angkatan'),
            'tahunAngkatan'         => $this->request->getPost('tahunAngkatan'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'flag'         => $this->request->getPost('flag'),
        );
    	$m_kelas->update(['id' => $id],$data);
    	$alert = view(
    		'partials/notification-alert',
    		[
    			'notif_text' => 'Data Mata Kuliah Berhasil Di Ubah',
    			'status' => 'success'
    		]
    	);

    	session()->setFlashdata('notif', $alert);
    	return redirect()->to('admin/kelas');
    }

}
