<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_rel_mhs_jad;
use App\Models\M_jadwal;
use App\Models\M_mahasiswa;
use App\Models\M_tahunajaran;

class registrasi extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_rel_mhs_jad = new M_rel_mhs_jad();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $cekRegis = $m_rel_mhs_jad->select('COUNT(id) AS hitung')
            ->where('mahasiswaID', $mahasiswaID)
            ->get()->getResult()[0]
            ->hitung;
        
        $cekMasaRegis = $m_tahunajaran->cekMasaRegis()[0]->hitung;
        $data = [
            'title' => 'Registrasi Mata Kuliah',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'cekRegis' => $cekRegis,
            'cekMasaRegis' => $cekMasaRegis
        ];

        return view('mahasiswa/registrasi/registrasi', $data);
    }

    // ? Load data into json
    public function data_matkul_periode()
    {
        $m_user = new M_user();
        $m_rel_mhs_jad = new M_rel_mhs_jad();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_jadwal = $m_rel_mhs_jad->getJadwalMhs($account->user_id);
        $data = [
            'title' => 'Jadwal',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_jadwal' => $list_jadwal
        ];

        return json_encode($data);
    }

    public function data_jadwal()
    {
        $m_user = new M_user();
        $m_jadwal = new M_jadwal();
        $m_mahasiswa = new M_mahasiswa();
        $account = $m_user->getAccount(session()->get('user_id'));

        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $list_jadwal = $m_jadwal->getJadwalRegistrasiMhs($mahasiswaID);
        $data = [
            'title' => 'Jadwal',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_jadwal' => $list_jadwal
        ];

        return json_encode($data);
    }

    public function data_jadwal_selected()
    {
        $m_user = new M_user();
        $m_jadwal = new M_jadwal();
        $m_mahasiswa = new M_mahasiswa();
        $account = $m_user->getAccount(session()->get('user_id'));

        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $list_jadwal = $m_jadwal->getJadwalSelectedMhs($mahasiswaID);
        $data = [
            'title' => 'Jadwal',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'list_jadwal' => $list_jadwal
        ];

        return json_encode($data);
    }

    public function regis_proc()
    {
        if ($this->request->isAJAX()) {
            $m_rel_mhs_jad = new M_rel_mhs_jad();
            $m_mahasiswa = new M_mahasiswa();

            $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
                ->get()->getResult()[0]
                ->id;
            $selectedData = $this->request->getPost('selectedData');
            foreach($selectedData as $row){
                $dataset = [
                    'status' => 'waiting',
                    'flag' => 1,
                    'mahasiswaID' => $mahasiswaID,
                    'jadwalID' => $row['id']
                ];
                $m_rel_mhs_jad->where('mahasiswaID', $mahasiswaID)->delete();
                $m_rel_mhs_jad->insert($dataset);
            }
        }
        return redirect()->back();
    }
    
}
