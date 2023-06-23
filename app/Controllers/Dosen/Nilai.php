<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;
use App\Models\M_jadwal;
use App\Models\M_kehadiran;
use App\Models\M_mahasiswa;
use App\Models\M_nilai;
use App\Models\M_param_nilai;

class Nilai extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Kelola Nilai',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
        ];

        return view('dosen/nilai/matkul-list', $data);
    }

    public function list_mhs($id = false)
    {
        $m_user = new M_user();
        $m_jadwal = new M_jadwal();

        $account = $m_user->getAccount(session()->get('user_id'));
        $detail_matkul = $m_jadwal->getJadwalDosenNilai($id)[0];
        
        $data = [
			'title' => 'Kelola BAP',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
            'detail_matkul' => $detail_matkul
        ];
        
        return view('dosen/nilai/mhs-list', $data);
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

    public function data_mhs($id = false)
    {
        $m_user = new M_user();
        $m_dosen = new M_dosen();
        $m_mahasiswa = new M_mahasiswa();

        $list_mhs = $m_mahasiswa->getListMhsNilai($id);

        $data = [
            'data' => $list_mhs
        ];

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

        return view('dosen/nilai/part-nilai-edit', $data);
	}

    public function submit_nilai()
    {
        $m_nilai = new M_nilai();
        $m_param_nilai = new M_param_nilai();
        $m_kehadiran = new M_kehadiran();

        $mhs_id = $this->request->getPost('mhs_id');
        $matkul_id = $this->request->getPost('matkul_id');
        $nilaiTugas = $this->request->getPost('nilaiTugas');
        $nilaiPraktek = $this->request->getPost('nilaiPraktek');
        $nilaiUTS = $this->request->getPost('nilaiUTS');
        $nilaiUAS = $this->request->getPost('nilaiUAS');
        $nilaiKehadiran = $this->request->getPost('nilaiKehadiran');
        $total = $this->request->getPost('total');

        $param_nilai = $m_param_nilai->getParamByMatkul($matkul_id)[0];
        $kehadiran = $m_kehadiran->getSinglePresensi($mhs_id, $matkul_id);

        $cek_nilai = $m_nilai->select('COUNT(id) AS hitung')
            ->where('mahasiswaID', $mhs_id)
            ->where('matakuliahID', $matkul_id)
            ->get()->getResult()[0]->hitung;
        
        $data = [
            'nilaiTugas' => $nilaiTugas,
            'nilaiPraktek' => $nilaiPraktek,
            'nilaiUTS' => $nilaiUTS,
            'nilaiUAS' => $nilaiUAS,
            'nilaiKehadiran' => $nilaiKehadiran
        ];

        if($nilaiTugas && $nilaiKehadiran && $nilaiPraktek && $nilaiUTS && $nilaiUAS){
            
            if($total > 79){
                $indeksNilai = 'A';
            }elseif($total > 59){
                $indeksNilai = 'B';
            }elseif($total > 49){
                $indeksNilai = 'C';
            }elseif($total > 34){
                $indeksNilai = 'D';
            }elseif($total > 19){
                $indeksNilai = 'E';
            }

            $data += [
                'nilaiAkhir' => $total,
                'indeksNilai' => $indeksNilai
            ];
        }

        if ($cek_nilai == 0) {
            
            $data += [
                'matakuliahID' => $matkul_id,
                'mahasiswaID' => $mhs_id
            ];

            $m_nilai->insert($data);

        }else{
            $m_nilai->set($data)->where('matakuliahID', $matkul_id)->where('mahasiswaID', $mhs_id)->update();
        }

        // $alert = view(
        //     'partials/notification-alert', 
        //     [
        //         'notif_text' => 'Nilai berhasil diset',
        //         'status' => 'success'
        //     ]
        // );
        
        // $notif = ['notif' => $alert];
        // session()->setFlashdata($notif);
        // return redirect()->back();
    }

}
