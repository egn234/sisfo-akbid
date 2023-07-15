<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kehadiran;
use App\Models\M_mahasiswa;
use App\Models\M_nilai;
use App\Models\M_kelas;
use App\Models\M_param_nilai;
use App\Models\M_tahunajaran;

class Nilai extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Kelola Nilai',
			'usertype' => 'Admin',
			'duser' => $account,
        ];

        return view('admin/nilai/kelas-list', $data);
    }

    public function list_mhs($id = false)
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));
        
        $data = [
			'title' => 'Kelola Nilai',
			'usertype' => 'Admin',
			'duser' => $account,
            'id_kls' => $id
        ];
        
        return view('admin/nilai/mhs-list', $data);
    }

    function detail_nilai($id = false)
    {
        $m_user = new M_user();
        $m_nilai = new M_nilai();
        $m_tahunajaran = new M_tahunajaran();

        $account = $m_user->getAccount(session()->get('user_id'));
        $mhs_id = $id;
        
        $all_nilai = $m_nilai->getIndeksNilaiMhs($mhs_id);
        $total_ipk = $this->hitung_ipk($all_nilai);

        $nilai_now = $m_nilai->getIndeksNilaiMhsNow($mhs_id);
        $ipk_now = $this->hitung_ipk($nilai_now);

        $list_periode = $m_tahunajaran->getPeriodeKHS($mhs_id);

        $data = [
            'title' => 'Kelola Nilai',
            'usertype' => 'Admin',
            'duser' => $account,
            'total_ipk' => $total_ipk,
            'ipk_now' => $ipk_now,
            'list_periode' => $list_periode,
            'mhs_id' => $mhs_id
        ];

        return view('admin/nilai/nilai-list', $data);
    }

    public function data_kelas()
    {
        $m_user = new M_user();
        $m_kelas = new M_kelas();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_kelas = $m_kelas->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Kelola Nilai',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_kelas' => $list_kelas
        ];

        return json_encode($data);
    }

    public function data_mhs($id = false)
    {
        $m_mahasiswa = new M_mahasiswa();

        $list_mhs = $m_mahasiswa->getMhsKelas($id);

        $data = [
            'data' => $list_mhs
        ];

        return json_encode($data);
    }

    public function data_nilai($id = false)
    {
        $m_nilai = new M_nilai();
        
        $data_nilai = $m_nilai->getAllINM($id);

        $data = ['data' => $data_nilai];

        return json_encode($data);
    }

	public function edit_nilai()
	{
        $m_nilai = new M_nilai();
        $m_param_nilai = new M_param_nilai();
        $m_kehadiran = new M_kehadiran();

        $mhs_id = $this->request->getPost('rowid');
        $matkul_id = $this->request->getPost('matkulId');
        
        $param_nilai = $m_param_nilai->getParamByMatkul($matkul_id)[0];
        $kehadiran = $m_kehadiran->getSinglePresensi($mhs_id, $matkul_id);

        $cek_nilai = $m_nilai->select('COUNT(id) AS hitung')
            ->where('mahasiswaID', $mhs_id)
            ->where('matakuliahID', $matkul_id)
            ->get()->getResult()[0]->hitung;
        
        $flag = ($cek_nilai == 0)? 0 : 1;

        $data = [
            'mhs_id' => $mhs_id,
            'matkul_id' => $matkul_id,
            'param_nilai' => $param_nilai,
            'kehadiran' => $kehadiran,
            'flag' => $flag
        ];
        
        if($flag > 0){
            $nilai = $m_nilai->where('mahasiswaID', $mhs_id)
                ->where('matakuliahID', $matkul_id)
                ->get()->getResult()[0];

            $data += ['nilai' => $nilai];
        }

        return view('admin/nilai/part-nilai-edit', $data);
	}

    public function submit_nilai()
    {
        $m_nilai = new M_nilai();

        $mhs_id = $this->request->getPost('mhs_id');
        $matkul_id = $this->request->getPost('matkul_id');

        $total = number_format((float) $this->request->getPost('total'), 2, '.', '');

        $cek_nilai = $m_nilai->select('COUNT(id) AS hitung')
            ->where('mahasiswaID', $mhs_id)
            ->where('matakuliahID', $matkul_id)
            ->get()->getResult()[0]->hitung;
        
            
        if($total >= 87.75){$indeksNilai = 'A';}
        elseif($total >= 68.75){$indeksNilai = 'B';}
        elseif($total >= 50){$indeksNilai = 'C';}
        elseif($total >= 25){$indeksNilai = 'D';}
        elseif($total >= 0){$indeksNilai = 'E';}

        $data = [
            'nilaiAkhir' => $total,
            'indeksNilai' => $indeksNilai
        ];

        if ($cek_nilai == 0) {
            
            $data += [
                'matakuliahID' => $matkul_id,
                'mahasiswaID' => $mhs_id
            ];

            $m_nilai->insert($data);

        }else{
            $m_nilai->set($data)->where('matakuliahID', $matkul_id)->where('mahasiswaID', $mhs_id)->update();
        }

        $alert = view(
            'partials/notification-alert', 
            [
                'notif_text' => 'Nilai akhir berhasil diset',
                'status' => 'success'
            ]
        );
        
        $notif = ['notif' => $alert];
        session()->setFlashdata($notif);
        return redirect()->back();
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

        $ipk = ($sum_ipk == 0 || $sum_sks == 0)? 0 :$sum_ipk / $sum_sks;

        $data = [
            'ipk' => $ipk,
            'sks' => $sum_sks
        ];

        return $data;
    }

}
