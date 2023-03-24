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

    public function process_input()
    {
        $m_kuesioner = new M_kuesioner();

        $data = array(
            'judul_kuesioner'       => $this->request->getPost('judul_kuesioner'),
            'flag'         => $this->request->getPost('flag'),
        );

        $check = $m_kuesioner->insert($data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Kuesioner Berhasil DiTambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kuesioner');
    }

    public function process_input_pertanyaan()
    {
        $m_pertanyaan = new M_pertanyaan();

        $data = array(
            'pertanyaan'       => $this->request->getPost('pertanyaan'),
            'jenis_pertanyaan'       => $this->request->getPost('jenis_pertanyaan'),
            'flag'         => $this->request->getPost('flag'),
            'kuesionerID' => $this->request->getPost('kuesionerID')
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
        return redirect()->to('admin/kuesioner');
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

    public function process_delete_pertanyaan()
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
        return redirect()->to('admin/kuesioner');
    }

    public function process_update()
    {
        $m_kuesioner = new M_kuesioner();
        $id = $this->request->getPost('idPut');
        $data = array(
            'judul_kuesioner'       => $this->request->getPost('judul_kuesioner'),
            'flag'         => $this->request->getPost('flag'),
        );
        $m_kuesioner->update(['id' => $id], $data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Kuesioner Berhasil Di Ubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kuesioner');
    }

    public function process_update_pertanyaan()
    {
        $m_pertanyaan = new M_pertanyaan();
        $id = $this->request->getPost('idPut');
        $data = array(
            'pertanyaan'       => $this->request->getPost('pertanyaan'),
            'jenis_pertanyaan'       => $this->request->getPost('jenis_pertanyaan'),
            'flag'         => $this->request->getPost('flagPertanyaan'),
        );
        $check = $m_pertanyaan->update(['id' => $id], $data);

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Pertanyaan Berhasil Di Ubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/kuesioner');
    }

    public function flag_switch()
    {
        $m_kuesioner = new M_kuesioner();
        $id = $this->request->getPost('idPut');
        $data = array(
            'flag'         => $this->request->getPost('flag'),
        );
        $m_kuesioner->update(['id' => $id], $data);
        if ($data['flag'] == 1) {
            $alert = array(
                [
                    'notif_text' => 'Data Kuesioner Berhasil Di Aktifkan',
                    'status' => 'success'
                ]
            );
        } else {
            $alert = array(
                [
                    'notif_text' => 'Data Kuesioner Berhasil Di Non-Aktifkan',
                    'status' => 'success'
                ]
            );
        }
        return json_encode($alert);
    }
}
