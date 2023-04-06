<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_ruangan;

class Ruangan extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Daftar Ruangan',
			'usertype' => 'Admin',
			'duser' => $account
		];

		return view('admin/ruangan/list-ruangan', $data);
	}

	// ? Load data into json
	public function data_ruangan()
	{
		$m_user = new M_user();
		$m_ruangan = new M_ruangan();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_ruangan = $m_ruangan->select('*')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Ruangan',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_ruangan' => $list_ruangan
		];

		return json_encode($data);
	}

    public function process_input()
	{
		$m_ruangan = new M_ruangan();
		
		$kodeRuangan = strtoupper((string) $this->request->getPost('kodeRuangan'));
		$namaRuangan = strtoupper((string) $this->request->getPost('namaRuangan'));
		$deskripsi = $this->request->getPost('deskripsi');

		$cek_kode = $m_ruangan->select('COUNT(id) AS hitung')
			->where('kodeRuangan', $kodeRuangan)
			->get()->getResult()[0]
			->hitung;

		if ($cek_kode != 0) {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kode ruangan telah terdaftar',
					'status' => 'warning'
				]
			);
	
			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		$data = [
			'kodeRuangan' => $kodeRuangan,
			'namaRuangan' => $namaRuangan,
			'deskripsi' => $deskripsi,
		];
		
		$m_ruangan->insert($data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Ruangan berhasil dibuat',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/ruangan');
	}

    public function process_delete()
    {
		$m_ruangan = new M_ruangan();
        $id = $this->request->getPost('idDel');
        $check = $m_ruangan->delete(array('id ' => $id));
        $alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Berhasil Dihapus',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/ruangan');
    }

	public function process_update()
	{
		$m_ruangan = new M_ruangan();
		$id = $this->request->getPost('idPut');
		$data = array(
			'kodeRuangan'       => $this->request->getPost('kodeRuangan'),
			'namaRuangan'       => $this->request->getPost('namaRuangan'),
			'deskripsi' 		=> $this->request->getPost('deskripsi'),
		);
		$m_ruangan->update(['id' => $id],$data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Mata Kuliah Berhasil Di Ubah',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/ruangan');
	}

	public function flag_switch()
	{
		$m_ruangan = new M_ruangan();
		$ruangan_id = $this->request->getPost('id_data');
		$ruangan = $m_ruangan->where('id', $ruangan_id)->first();
		if ($ruangan['flag'] == 0) {
			$m_ruangan->where('id', $ruangan_id)->set('flag', '1')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Ruangan Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($ruangan['flag'] == 1) {
			$m_ruangan->where('id', $ruangan_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Ruangan Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
	}
}
