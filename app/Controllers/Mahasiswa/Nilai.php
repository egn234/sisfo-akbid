<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\M_mahasiswa;
use App\Models\M_user;
use App\Models\M_nilai;
use App\Models\M_tahunajaran;

class Nilai extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_nilai = new M_nilai();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $mhs_id = $m_mahasiswa->where("userID", session()->get('user_id'))
            ->get()->getResult()[0]->id;
        
        $all_nilai = $m_nilai->getIndeksNilaiMhs($mhs_id);
        $total_ipk = $this->hitung_ipk($all_nilai);

        $nilai_now = $m_nilai->getIndeksNilaiMhsNow($mhs_id);
        $ipk_now = $this->hitung_ipk($nilai_now);

        $list_periode = $m_tahunajaran->getPeriodeKHS($mhs_id);

        $data = [
            'title' => 'Nilai',
            'usertype' => session()->get('userType'),
            'duser' => $account,
            'total_ipk' => $total_ipk,
            'ipk_now' => $ipk_now,
            'list_periode' => $list_periode
        ];

        return view('mahasiswa/nilai/nilai-list', $data);
    }

    function hitung_ipk($data_nilai) : array
    {           
        $sum_ipk = 0;
        $sum_sks = 0;
        foreach($data_nilai as $k){

            $bobot = 0;
            if ($k->indeksNilai == "A") {$bobot = 4;}
            elseif ($k->indeksNilai == "B") {$bobot = 3;}
            elseif ($k->indeksNilai == "C") {$bobot = 2;}
            elseif ($k->indeksNilai == "D") {$bobot = 1;}
            elseif ($k->indeksNilai == "E") {$bobot = 0;}
            else{$bobot = 4;}
            
            $sum_indeks = $k->sks * $bobot;
            $sum_ipk = $sum_ipk + $sum_indeks;
            $sum_sks = $sum_sks + $k->sks;
        }

        $ipk = $sum_ipk / $sum_sks;

        $data = [
            'ipk' => $ipk,
            'sks' => $sum_sks
        ];

        return $data;
    }

    public function data_nilai()
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_nilai = new M_nilai();
        
        $mhs_id = $m_mahasiswa->where("userID", session()->get('user_id'))
            ->get()->getResult()[0]->id;
        
        $data_nilai = $m_nilai->getIndeksNilaiMhs($mhs_id);

        $data = ['data' => $data_nilai];

        return json_encode($data);
    }

    function print_khs($periode_id = false)
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_nilai = new M_nilai();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $mahasiswaID = $m_mahasiswa->where('userID', session()->get('user_id'))
            ->get()->getResult()[0]
            ->id;

        $data = [];
        $detail_mahasiswa = $m_mahasiswa->where('id', $mahasiswaID)->get()->getResult()[0];

        if ($periode_id) {
            $list_matkul = $m_nilai->getKHSPeriode($mahasiswaID, $periode_id);
            $link = 'mahasiswa/partials/print-khs-single';
            $periode = $m_tahunajaran->where('id', $periode_id)->get()->getResult()[0];
            $data += [
                'tahunPeriode' => $periode->tahunPeriode,
                'semester' => $periode->semester
            ];
        }else{
            $list_matkul = $m_nilai->getAllKHS($mahasiswaID);
            $link = 'mahasiswa/partials/print-khs-all';
        }

        $ipk = $this->hitung_ipk($list_matkul);

        $data += [
            'detail_mhs' => $detail_mahasiswa,
            'list_matkul' => $list_matkul,
            'ipk' => $ipk
        ];

        return view($link, $data);
    }
    
}
