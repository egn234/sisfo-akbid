<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;
use App\Models\M_bap;
use App\Models\M_jadwal;
use App\Models\M_mahasiswa;
use App\Models\M_kehadiran;

class Bap extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Kelola BAP',
            'usertype' => session()->get('user_type'),
            'duser' => $account
        ];

        return view('dosen/bap/matkul-list', $data);
    }

    public function list_bap($id = false)
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Kelola BAP',
            'usertype' => session()->get('user_type'),
            'duser' => $account,
            'jadwal_id' => $id
        ];

        return view('dosen/bap/bap-list', $data);
    }

    public function detail_bap($id = false)
    {
        $m_bap = new M_bap();
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));
        $detail_bap = $m_bap->getDetailBapDosen($id)[0];

        $data = [
            'title' => 'Kelola BAP',
            'usertype' => session()->get('user_type'),
            'duser' => $account,
            'detail_bap' => $detail_bap
        ];

        return view('dosen/bap/bap-detail', $data);
    }

    public function save_absensi()
    {
        $m_kehadiran = new M_kehadiran();
        $postData = $this->request->getPost();
        $bap_id = $this->request->getPost('bap_id');

        // Loop through the POST data to retrieve the status values
        foreach ($postData as $key => $value) {
            if (strpos($key, 'status_') === 0) {
                $studentId = substr($key, strlen('status_'));
                $status = $value;

                $data = [
                    'status' => $status,
                    'mahasiswaID' => $studentId,
                    'bapID' => $bap_id
                ];

                $cek_absensi = $m_kehadiran->select("COUNT(id) AS hitung")
                    ->where('mahasiswaID', $studentId)
                    ->where('bapID', $bap_id)
                    ->get()->getResult()[0]->hitung;

                if($cek_absensi == 0){
                    $m_kehadiran->insert($data);
                }else{
                    $m_kehadiran->set('status', $status)
                        ->where('mahasiswaID', $studentId)
                        ->where('bapID', $bap_id)->update();
                }
            }
        };

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Kehadiran berhasil disubmit',
                'status' => 'success'
            ]
        );

        $notif = ['notif' => $alert];
        session()->setFlashdata($notif);
        return redirect()->back();
    }

    public function data_matkul()
    {
        $m_user = new M_user();
        $m_dosen = new M_dosen();
        $m_jadwal = new M_jadwal();

        $id = $m_dosen->where('userID', session()->get('user_id'))->get()->getResult()[0]->id;

        $list_matkul = $m_jadwal->getJadwalDosen($id);

        $data = [
            'data' => $list_matkul
        ];

        return json_encode($data);
    }

    public function data_bap($jadwal_id = false)
    {
        $m_user = new M_user();
        $m_dosen = new M_dosen();
        $m_bap = new M_bap();

        $id = $m_dosen->where('userID', session()->get('user_id'))->get()->getResult()[0]->id;
        $list_bap = $m_bap->getBapDosen($id, $jadwal_id);

        $data = [
            'data' => $list_bap
        ];

        return json_encode($data);
    }

    public function data_mhs($id = false)
    {
        $m_mahasiswa = new M_mahasiswa();
        $list_mhs = $m_mahasiswa->getListMhsBap($id);

        $data = [
            'data' => $list_mhs
        ];

        return json_encode($data);
    }

    public function add_bap()
    {
        $m_bap = new M_bap();

        $jadwal_id = $this->request->getPost('jadwal_id');
        $mingguPertemuan = $this->request->getPost('pertemuan');
        $materiPertemuan = $this->request->getPost('materi');

        $data = [
            'jadwalID' => $jadwal_id,
            'mingguPertemuan' => $mingguPertemuan,
            'materiPertemuan' => $materiPertemuan
        ];

        $m_bap->insert($data);

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'BAP berhasil dibuat',
                'status' => 'success'
            ]
        );

        $notif = ['notif' => $alert];
        session()->setFlashdata($notif);
        return redirect()->back();
    }

    public function get_status_kehadiran()
    {
        $m_kehadiran = new M_kehadiran();

        $mahasiswaID = $_GET['studentId'];
        $bap_id = $_GET['bap_id'];

        $status = $m_kehadiran->where('mahasiswaID', $mahasiswaID)
            ->where('bapID', $bap_id)
            ->get()->getResult();
        if (count($status) != 0) {
            $jumlah = count($status)-1;
            $data = ['status' => $status[$jumlah]->status];
        }else{
            $data = ['status' => "Kosong"];
        }
        

        return json_encode($data);

    }
}
