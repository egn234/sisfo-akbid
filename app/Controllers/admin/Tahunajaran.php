<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_tahunajaran;

class Tahunajaran extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title'     => 'Daftar Tahun Ajaran',
            'usertype'  => 'Admin',
            'duser'     => $account
        ];

        return view('admin/tahunajaran/list-tahunajaran', $data);
    }

    // ? Load data into json
    public function data_tahunajaran()
    {
        $m_user = new M_user();
        $m_tahunajaran = new M_tahunajaran();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_tahunajaran = $m_tahunajaran->select('*')
            ->get()
            ->getResult();
        $data = [
            'title'     => 'Daftar Tahun Ajaran',
            'usertype'  => 'Admin',
            'duser'     => $account,
            'list_tahunajaran' => $list_tahunajaran
        ];

        return json_encode($data);
    }

    public function process_input()
    {
        $m_tahunajaran = new M_tahunajaran();

        $data = array(
            'tahunPeriode'      => $this->request->getPost('tahunPeriode'),
            'semester'          => $this->request->getPost('semester'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'flag'              => $this->request->getPost('flag')

        );

        $check = $m_tahunajaran->insert($data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Periode Berhasil DiTambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/tahunAjaran');
    }

    public function process_delete()
    {
        $m_tahunajaran = new M_tahunajaran();
        $id = $this->request->getPost('idDel');
        $check = $m_tahunajaran->delete(array('id ' => $id));
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Berhasil Dihapus',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/tahunAjaran');
    }

    public function process_update()
    {
        $m_tahunajaran = new M_tahunajaran();
        $id = $this->request->getPost('idPut');
        $data = array(
            'tahunPeriode'      => $this->request->getPost('tahunPeriode'),
            'semester'          => $this->request->getPost('semester'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'flag'              => $this->request->getPost('flag')

        );
        $m_tahunajaran->update(['id' => $id], $data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Periode Berhasil Di Ubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/tahunAjaran');
    }
}
