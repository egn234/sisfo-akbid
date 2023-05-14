<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_tahunajaran;

class Tahunajaran extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title'     => 'Daftar Tahun Ajaran',
            'usertype'  => 'Admin',
            'duser'     => $account
        ];

        return view('admin/tahunajaran/list-tahunajaran', $data);
    }

    // ? Load data into json
    public function data_tahunajaran()
    {
        $m_user = new M_user();
        $m_tahunajaran = new M_tahunajaran();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_tahunajaran = $m_tahunajaran->select('*')
            ->get()
            ->getResult();
        $data = [
            'title'     => 'Daftar Tahun Ajaran',
            'usertype'  => 'Admin',
            'duser'     => $account,
            'list_tahunajaran' => $list_tahunajaran
        ];

        return json_encode($data);
    }

    public function process_input()
    {
        $m_tahunajaran = new M_tahunajaran();

        $tahun1 = $this->request->getPost('tahun1');
        $tahun2 = $this->request->getPost('tahun2');
        $semester = $this->request->getPost('semester');
        $deskripsi = $this->request->getPost('deskripsi');

        $registrasi_awal = $this->request->getPost('registrasi_awal');
        $registrasi_akhir = $this->request->getPost('registrasi_akhir');

        $periode = (string) $tahun1 . '/' . $tahun2;

        $cek_count = $m_tahunajaran->select("COUNT(id) AS hitung")
            ->where('tahunPeriode', $periode)
            ->where('semester', $semester)
            ->get()->getResult()[0]
            ->hitung;
        
        if($cek_count > 0){
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Tahun Ajaran telah terdaftar',
                    'status' => 'danger'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        if ($registrasi_awal > $registrasi_akhir) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'tanggal awal tidak boleh melebihi tanggal akhir',
                    'status' => 'danger'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        if($semester == ''){
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Pilih semester terlebih dahulu',
                    'status' => 'danger'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'tahunPeriode' => $periode,
            'semester' => $semester,
            'registrasi_awal' => $registrasi_awal,
            'registrasi_akhir' => $registrasi_akhir,
            'deskripsi' => $deskripsi
        ];

        try {
            $m_tahunajaran->insert($data);

            $periode_id = $m_tahunajaran->select('id')->where($data)->get()->getResult()[0]->id;
            $m_tahunajaran->set('flag', 0)->where('id != '.$periode_id)->update();

        } catch (\Throwable $th) {
            throw $th;
        }

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Tahun Ajaran berhasil ditambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function process_delete()
    {
        $m_tahunajaran = new M_tahunajaran();
        $id = $this->request->getPost('idDel');
        $check = $m_tahunajaran->delete(array('id ' => $id));
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Berhasil Dihapus',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/tahunAjaran');
    }

    public function process_update()
    {
        $m_tahunajaran = new M_tahunajaran();
        $id = $this->request->getPost('idPut');

        $tahun1 = $this->request->getPost('tahun1');
        $tahun2 = $this->request->getPost('tahun2');
        $semester = $this->request->getPost('semester');
        $deskripsi = $this->request->getPost('deskripsi');

        $periode = (string) $tahun1 . '/' . $tahun2;

        $registrasi_awal = $this->request->getPost('registrasi_awal');
        $registrasi_akhir = $this->request->getPost('registrasi_akhir');

        $cek_count = $m_tahunajaran->select("COUNT(id) AS hitung")
            ->where('tahunPeriode', $periode)
            ->where('semester', $semester)
            ->where('id != '.$id)
            ->get()->getResult()[0]
            ->hitung;

        if($cek_count > 0){
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Tahun Ajaran telah terdaftar',
                    'status' => 'danger'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        if ($registrasi_awal > $registrasi_akhir) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'tanggal awal tidak boleh melebihi tanggal akhir',
                    'status' => 'danger'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        if($semester == ''){
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Pilih semester terlebih dahulu',
                    'status' => 'danger'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'tahunPeriode' => $periode,
            'semester' => $semester,
            'registrasi_awal' => $registrasi_awal,
            'registrasi_akhir' => $registrasi_akhir,
            'deskripsi' => $deskripsi
        ];

        try {
            $m_tahunajaran->set($data)->where('id', $id)->update();
        } catch (\Throwable $th) {
            throw $th;
        }
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Tahun Ajaran berhasil ditambahkan',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function flag_switch()
	{
		$m_tahunajaran = new M_tahunajaran();
		$periode_id = $this->request->getPost('id_data');
		$periode = $m_tahunajaran->where('id', $periode_id)->first();
		if ($periode['flag'] == 0) {
			$m_tahunajaran->where('id', $periode_id)->set('flag', '1')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Periode Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($periode['flag'] == 1) {
			$m_tahunajaran->where('id', $periode_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Periode Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
	}
}
