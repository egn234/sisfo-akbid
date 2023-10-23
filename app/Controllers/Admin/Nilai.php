<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_kehadiran;
use App\Models\M_mahasiswa;
use App\Models\M_nilai;
use App\Models\M_kelas;
use App\Models\M_prodi;
use App\Models\M_matkul;
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

    public function import_nilai()
    {
        $m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
        $m_prodi = new M_prodi();
        $m_matkul = new M_matkul();
        $m_nilai = new M_nilai();
		
		$file = $this->request->getFile('file_import');

		if ($file->isValid())
		{
			$ext = $file->guessExtension();
			$filepath = WRITEPATH . 'uploads/' . $file->store();

			if ($ext == 'csv') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} elseif ($ext == 'xls' || $ext == 'xlsx') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$reader->setReadDataOnly(true);
			$reader->setReadEmptyCells(false);
			$spreadsheet = $reader->load($filepath);
			$err_count = 0;
			$baris_proc = 0;

            $list_err_mhs = [];
            $list_err_prodi = [];
            $list_err_matkul = [];

			foreach ($spreadsheet->getWorksheetIterator() as $cell) {
				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i = 2; $i <= $baris; $i++) {
					$nim = $cell->getCell('B'.$i)->getValue();
					$nama = $cell->getCell('C'.$i)->getValue();
					$prodi = $cell->getCell('D'.$i)->getValue();
					$kodeMatkul = $cell->getCell('E'.$i)->getValue();
					$namaMatkul = $cell->getCell('F'.$i)->getValue();
					$nilai_akhir = (float) $cell->getCell('G'.$i)->getValue();
					$indeks = $cell->getCell('H'.$i)->getValue();
					
            		list($strata, $nama_prodi) = explode(' ', $prodi, 2);

                    $cek_mhs = $m_mahasiswa->select('count(id) as hitung')
                        ->where('nim', $nim)
                        ->get()->getResult()[0]
                        ->hitung;

                    if($cek_mhs == 0){
                        if (!in_array($nama, $list_err_mhs)) {
                            $list_err_mhs[] = $nama;
                        }
                    }

                    $cek_prodi = $m_prodi->select('count(id) as hitung')
                        ->where('nama_prodi', $nama_prodi)
                        ->where('strata', $strata)
                        ->get()->getResult()[0]
                        ->hitung;

                    if($cek_prodi == 0){
                        if (!in_array($prodi, $list_err_prodi)) {
                            $list_err_prodi[] = $prodi;
                        }
                    }

                    $cek_matkul = $m_matkul->select('count(id) as hitung')
                        ->where('kodeMatkul LIKE "%'.$kodeMatkul.'%"')
                        ->get()->getResult()[0]
                        ->hitung;

                    if($cek_matkul == 0){
                        if (!in_array($namaMatkul, $list_err_matkul)) {
                            $list_err_matkul[] = $namaMatkul;
                        }
                    }

					if ($cek_matkul != 0 && $cek_mhs != 0 && $cek_prodi != 0) {
                        $mahasiswaID = $m_mahasiswa->where('nim', $nim)
                            ->get()->getResult()[0]
                            ->id;

                        $matakuliahID = $m_matkul->where('kodeMatkul LIKE "%'.$kodeMatkul.'%"')
                            ->get()->getResult()[0]
                            ->id;

                        $data = [
                            'mahasiswaID' => $mahasiswaID,
                            'matakuliahID' => $matakuliahID,
                            'indeksNilai' => $indeks,
                            'nilaiAkhir' => $nilai_akhir,
                            'nilaiKehadiran' => 0,
                            'nilaiPraktek' => 0,
                            'nilaiTugas' => 0,
                            'nilaiUAS' => 0,
                            'nilaiUTS' => 0
                        ];

                        $m_nilai->insert($data);
					}else{
                        $err_count++;
                    }

					$baris_proc++;
				}
			}
			$total_count = $baris_proc - $err_count;

			if (!empty($list_err_prodi)) {
				// Generate an error message grouped by "prodi"
				$error_message = 'Error: The following "prodi" names do not exist in the database:<br>';
				
				foreach ($list_err_prodi as $prodi) {
					$error_message .= '- ' . $prodi . '<br>';
				}
			
				// Create an alert for the error
				$alert = view(
					'partials/notification-alert',
					[
						'notif_text' => $error_message,
						'status' => 'danger'
					]
				);
			
				$data_session = [
					'notif_1' => $alert
				];
			}

            if (!empty($list_err_matkul)) {
				// Generate an error message grouped by "prodi"
				$error_message = 'Error: The following "matakuliah" names do not exist in the database:<br>';
				
				foreach ($list_err_matkul as $matkul) {
					$error_message .= '- ' . $matkul . '<br>';
				}
			
				// Create an alert for the error
				$alert = view(
					'partials/notification-alert',
					[
						'notif_text' => $error_message,
						'status' => 'danger'
					]
				);
			
				$data_session = [
					'notif_2' => $alert
				];
			}

            if (!empty($list_err_mhs)) {
				// Generate an error message grouped by "prodi"
				$error_message = 'Error: The following "mahasiswa" names do not exist in the database:<br>';
				
				foreach ($list_err_mhs as $mahasiswa) {
					$error_message .= '- ' . $mahasiswa . '<br>';
				}
			
				// Create an alert for the error
				$alert = view(
					'partials/notification-alert',
					[
						'notif_text' => $error_message,
						'status' => 'danger'
					]
				);
			
				$data_session = [
					'notif_3' => $alert
				];
			}
			
			if ($err_count > 0 && $total_count != 0) {
				$alert = view(
					'partials/notification-alert', 
					[
						'notif_text' => 'Berhasil mengimpor beberapa data user ('.$total_count.' berhasil, '.$err_count.' gagal)',
						'status' => 'warning'
					]
				);
				
				$data_session = [
					'notif' => $alert
				];
			}
			elseif ($err_count == $baris_proc) {
				$alert = view(
					'partials/notification-alert', 
					[
						'notif_text' => 'Gagal mengimpor data user ('.($total_count).' berhasil, '.$err_count.' gagal)',
						'status' => 'danger'
					]
				);
				
				$data_session = [
					'notif' => $alert
				];    
			}
			elseif ($err_count == 0) {
				$alert = view(
					'partials/notification-alert', 
					[
						'notif_text' => 'Berhasil mengimpor data user ('.$total_count.' berhasil, '.$err_count.' gagal)',
						'status' => 'success'
					]
				);
				
				$data_session = [
					'notif' => $alert
				];
			}
				
			unlink($filepath);
			session()->setFlashdata($data_session);
			return redirect()->back();
			
		} else {
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'Upload gagal',
					'status' => 'danger'
				]
			);
			
			$dataset = ['notif' => $alert];
			session()->setFlashdata($dataset);
			return redirect()->back();
		}
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

        $mhs_id = $this->request->getPost('rowid');
        $matkul_id = $this->request->getPost('matkulId');
        
        $param_nilai = $m_param_nilai->getParamByMatkul($matkul_id)[0];

        $cek_nilai = $m_nilai->select('COUNT(id) AS hitung')
            ->where('mahasiswaID', $mhs_id)
            ->where('matakuliahID', $matkul_id)
            ->get()->getResult()[0]->hitung;
        
        $flag = ($cek_nilai == 0)? 0 : 1;

        $data = [
            'mhs_id' => $mhs_id,
            'matkul_id' => $matkul_id,
            'param_nilai' => $param_nilai,
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
        
            
        if($total >= 80){$indeksNilai = 'A';}
        elseif($total >= 70){$indeksNilai = 'B';}
        elseif($total >= 60){$indeksNilai = 'C';}
        elseif($total >= 50){$indeksNilai = 'D';}
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
