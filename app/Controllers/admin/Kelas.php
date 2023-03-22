<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kelas;
use App\Models\M_rel_dsn_kls;


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

    public function detail_kelas($id = false)
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Daftar Kelas',
            'titleDetail' => 'Detail Kelas',
            'usertype' => 'Admin',
            'duser' => $account,
            'idKelas' => $id
        ];

        return view('admin/kelas/detail-kelas', $data);
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

    public function detail_data_kelas()
    {
        $m_user = new M_user();
        $m_kelas = new M_kelas();
        $id = $this->request->getPost('id');
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_kelas = $m_kelas->select('tb_kelas.id AS idKelas,tb_kelas.kodeKelas, tb_kelas.angkatan, tb_kelas.tahunAngkatan, tb_kelas.deskripsi, tb_dosen.kodeDosen, tb_dosen.nama AS namaDosen, tb_dosen.nip AS nipDosen, tb_dosen.id as idDosen, tb_mahasiswa.*')
            ->join('rel_dsn_kls', 'tb_kelas.id = rel_dsn_kls.kelasID', 'left')
            ->join('tb_dosen', 'tb_dosen.id = rel_dsn_kls.dosenID', 'left')
            ->join('rel_mhs_kls', 'tb_kelas.id = rel_mhs_kls.kelasID', 'left')
            ->join('tb_mahasiswa', 'rel_mhs_kls.mahasiswaID = tb_mahasiswa.id', 'left')
            ->where('tb_kelas.id', $id)
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
        $m_kelas->update(['id' => $id], $data);
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

    public function add_dosen_wali()
    {
        $m_rel_dsn_kls = new M_rel_dsn_kls();
        $data = array(
            'dosenID'       => $this->request->getPost('dosenID'),
            'kelasID'       => $this->request->getPost('kelasID'),
            'flag'         => 1
        );

        $check = $m_rel_dsn_kls->insert($data);
        $alert = array(
            [
                'notif_text' => 'Wali Dosen Berhasil DiTambahkan',
                'status' => 'success'
            ]
        );
        return json_encode($alert);
    }
    public function remove_dosen_wali()
    {
        $m_rel_dsn_kls = new M_rel_dsn_kls();
        $id = $this->request->getPost('idDel');
        $m_rel_dsn_kls->where('dosenID', $id);
        $check = $m_rel_dsn_kls->delete();
        $alert = array(
            [
                'notif_text' => 'Wali Dosen Berhasil Diremove',
                'status' => 'success'
            ]
        );
        return json_encode($alert);

    }
}
