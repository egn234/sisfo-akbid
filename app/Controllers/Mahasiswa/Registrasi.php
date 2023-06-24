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
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $periode_id = $m_tahunajaran->where('flag', 1)->get()->getResult()[0]->id;

        $cekRegis = $m_tahunajaran->cekRegis($periode_id, $mahasiswaID)[0]->hitung;
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
                $m_rel_mhs_jad->insert($dataset);
            }
        }
        return redirect()->back();
    }

    public function ksm()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $periodeID = $m_tahunajaran->where('flag', 1)->get()->getResult()[0]->id;
        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $m_rel_mhs_jad = new M_rel_mhs_jad();
        $list_matkul = $m_rel_mhs_jad->getKSM($periodeID, $mahasiswaID);
            
        $cekMasaRegis = $m_tahunajaran->cekMasaRegis()[0]->hitung;

        $data = [
            'title' => 'Cetak KSM',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'cekMasaRegis' => $cekMasaRegis,
            'list_matkul' => $list_matkul
        ];

        return view('mahasiswa/registrasi/cetak_ksm', $data);

    }

    public function print_ksm()
    {
        $m_rel_mhs_jad = new M_rel_mhs_jad();
        $m_mahasiswa = new M_mahasiswa();
        $m_user = new M_user();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $periodeID = $m_tahunajaran->where('flag', 1)->get()->getResult()[0]->id;
        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $detail_mahasiswa = $m_mahasiswa->where('id', $mahasiswaID)->get()->getResult()[0];
        $list_matkul = $m_rel_mhs_jad->getKSM($periodeID, $mahasiswaID);

        $data = [
            'detail_mhs' => $detail_mahasiswa,
            'list_matkul' => $list_matkul
        ];

        return view('mahasiswa/partials/print-ksm', $data);
    }
    
}
