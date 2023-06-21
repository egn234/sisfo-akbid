<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kelas;
use App\Models\M_rel_dsn_kls;
use App\Models\M_rel_mhs_kls;
use App\Models\M_mahasiswa;




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

        $kodeKelas = strtoupper((string) $this->request->getPost('kodeKelas'));
        $angkatan = $this->request->getPost('angkatan');
        $tahunAngkatan = $this->request->getPost('tahunAngkatan');
        $deskripsi = $this->request->getPost('deskripsi');

        $cek_kelas = $m_kelas->select('COUNT(id) AS hitung')
            ->where('kodeKelas', $kodeKelas)
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_kelas != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Kode kelas telah terdaftar',
                    'status' => 'warning'
                ]
            );

            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'kodeKelas' => $kodeKelas,
            'angkatan' => $angkatan,
            'tahunAngkatan' => $tahunAngkatan,
            'deskripsi' => $deskripsi
        ];

        $m_kelas->insert($data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Kelas berhasil dibuat',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
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

        $kodeKelas = strtoupper((string) $this->request->getPost('kodeKelas'));
        $angkatan = $this->request->getPost('angkatan');
        $tahunAngkatan = $this->request->getPost('tahunAngkatan');
        $deskripsi = $this->request->getPost('deskripsi');

        $cek_kelas = $m_kelas->select('COUNT(id) AS hitung')
            ->where('kodeKelas', $kodeKelas)
            ->where('id != ' . $id)
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_kelas != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Kode kelas telah terdaftar',
                    'status' => 'warning'
                ]
            );

            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'kodeKelas' => $kodeKelas,
            'angkatan' => $angkatan,
            'tahunAngkatan' => $tahunAngkatan,
            'deskripsi' => $deskripsi
        ];

        $m_kelas->set($data)->where('id', $id)->update();
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Kelas berhasil diubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
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
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Dosen wali berhasil di set',
                'status' => 'success'
            ]
        );
        session()->setFlashdata('notif-dosen', $alert);
        return redirect()->back();
    }
    public function remove_dosen_wali()
    {
        $m_rel_dsn_kls = new M_rel_dsn_kls();
        $id = $this->request->getPost('idDel');
        $m_rel_dsn_kls->where('dosenID', $id);
        $check = $m_rel_dsn_kls->delete();
        $alert = array(
            [
                'notif_text' => 'Dosen wali berhasil dihapus',
                'status' => 'success'
            ]
        );
        return json_encode($alert);
    }

    public function ploting_Kelas_Mhs()
    {
        $m_rel_mhs_kls = new M_rel_mhs_kls();
        $mahasiswaId = $this->request->getPost('mahasiswaID');

        for ($i = 0; $i < count($mahasiswaId); $i++) {
            $cek_relasi = $m_rel_mhs_kls->select('count(id) as hitung')
                ->where('mahasiswaID', $mahasiswaId[$i])
                ->where('kelasID', $this->request->getPost('kelasID'))
                ->get()->getResult()[0]->hitung;

            if($cek_relasi > 0){
                $alert = view(
                    'partials/notification-alert',
                    [
                        'notif_text' => 'error',
                        'status' => 'warning'
                    ]
                );
        
                session()->setFlashdata('notif', $alert);
                return redirect()->back();                
            }
        }

        for ($i = 0; $i < count($mahasiswaId); $i++) {

            $data = array(
                'mahasiswaID'       => $mahasiswaId[$i],
                'kelasID'       => $this->request->getPost('kelasID'),
                'flag'         => 1
            );
            
            $cek_relasi = $m_rel_mhs_kls->select('count(id) as hitung')
                ->where('mahasiswaID', $mahasiswaId[$i])
                ->where('kelasID', $this->request->getPost('kelasID'))
                ->get()->getResult()[0]->hitung;

            if($cek_relasi == 0){
                $m_rel_mhs_kls->insert($data);             
            }
        }

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Mahasiswa berhasil ditambahkan kedalam kelas',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function remove_mhs()
    {
        $m_rel_mhs_kls = new M_rel_mhs_kls();
        $id = $this->request->getPost('idDel');
        $m_rel_mhs_kls->whereIn('mahasiswaID', $id);

        $check = $m_rel_mhs_kls->delete();
        
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Mahasiswa berhasil dihapus dari kelas',
                'status' => 'success'
            ]
        );
        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function flag_switch()
    {
        $m_kelas = new M_kelas();
        $kelas_id = $this->request->getPost('id_data');
        $kelas = $m_kelas->where('id', $kelas_id)->first();
        if ($kelas['flag'] == 0) {
            $m_kelas->where('id', $kelas_id)->set('flag', '1')->update();
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Kelas diaktifkan',
                    'status' => 'success'
                ]
            );

            session()->setFlashdata('notif', $alert);
        } elseif ($kelas['flag'] == 1) {
            $m_kelas->where('id', $kelas_id)->set('flag', '0')->update();
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Kelas dinonaktifkan',
                    'status' => 'success'
                ]
            );

            session()->setFlashdata('notif', $alert);
        }
        return redirect()->back();
    }
    public function data_mhs_flag()
	{
		$m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_mhs = $m_mahasiswa->select('tb_mahasiswa.* , rel_mhs_kls.id as idRelasiKls, tb_user.flag')
			->join('tb_user', 'tb_user.id = tb_mahasiswa.userID', 'left')
			->join('rel_mhs_kls', 'tb_mahasiswa.id = rel_mhs_kls.mahasiswaID', 'left')
			->where('tb_user.flag', '1')
			->orderBy('tb_mahasiswa.created_at', 'DESC')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_mhs' => $list_mhs
		];

		return json_encode($data);
	}
}
