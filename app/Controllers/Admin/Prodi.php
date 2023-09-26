<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_prodi;

class Prodi extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title'     => 'Daftar Prodi',
            'usertype'  => 'Admin',
            'duser'     => $account
        ];

        return view('admin/prodi/list-prodi', $data);
    }

    // ? Load data into json
    public function data_prodi()
    {
        $m_user = new M_user();
        $m_prodi = new M_prodi();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_prodi = $m_prodi->get()->getResult();
        $data = [
            'title'     => 'Daftar Prodi',
            'list_prodi' => $list_prodi
        ];

        return json_encode($data);
    }

    public function process_input()
    {
        $m_prodi = new M_prodi();

        $nama_prodi = strtoupper((string) $this->request->getPost('nama_prodi'));
        $strata = $this->request->getPost('strata');
        $deskripsi = $this->request->getPost('deskripsi');

        $cek_count = $m_prodi->select("COUNT(id) AS hitung")
            ->where('nama_prodi', $nama_prodi)
            ->where('strata', $strata)
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_count > 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Program Studi telah terdaftar',
                    'status' => 'danger'
                ]
            );

            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'nama_prodi' => $nama_prodi,
            'strata' => $strata,
            'deskripsi' => $deskripsi
        ];

        $m_prodi->insert($data);

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Program Studi berhasil ditambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function process_update()
    {
        $m_prodi = new M_prodi();
        $id = $this->request->getPost('idPut');

        $nama_prodi = strtoupper((string) $this->request->getPost('nama_prodi'));
        $strata = $this->request->getPost('strata');
        $deskripsi = $this->request->getPost('deskripsi');

        $cek_count = $m_prodi->select("COUNT(id) AS hitung")
            ->where('nama_prodi', $nama_prodi)
            ->where('strata', $strata)
            ->where('id != ' . $id)
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_count > 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Program Studi telah terdaftar',
                    'status' => 'danger'
                ]
            );

            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'nama_prodi' => $nama_prodi,
            'strata' => $strata,
            'deskripsi' => $deskripsi
        ];

        try {
            $m_prodi->set($data)->where('id', $id)->update();
        } catch (\Throwable $th) {
            throw $th;
        }
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Program Studi berhasil diubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }
}
