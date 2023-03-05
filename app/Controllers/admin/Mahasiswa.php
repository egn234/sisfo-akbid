<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_mahasiswa;

class Mahasiswa extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
		// $account = $m_user->where('id', session()->get('user_id'))->first();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_mhs = $m_mahasiswa->select('tb_mahasiswa.*, tb_user.username AS username, tb_user.id AS user_id, flag')
			->join('tb_user', 'tb_user.id = tb_mahasiswa.userID')
			->orderBy('tb_mahasiswa.created_at', 'DESC')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_mhs' => $list_mhs
		];

		return view('admin/mhs/list-mahasiswa', $data);
	}

	// ? Load data into json
	public function data_mhs()
	{
		$m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
		// $account = $m_user->where('id', session()->get('user_id'))->first();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_mhs = $m_mahasiswa->select('tb_mahasiswa.*, tb_user.username AS username, tb_user.id AS user_id, flag')
			->join('tb_user', 'tb_user.id = tb_mahasiswa.userID')
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


	public function add_mhs()
	{
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Tambah Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account
		];

		return view('admin/mhs/add-mhs', $data);
	}

	public function flag_switch($user_id = false)
	{
		$m_user = new M_user();
		$user = $m_user->where('id', $user_id)->first();

		if ($user['flag'] == 0) {
			$m_user->where('id', $user_id)->set('flag', '1')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'User Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($user['flag'] == 1) {
			$m_user->where('id', $user_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'User Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}

		return redirect()->back();
	}

	public function konfirSwitch()
	{
		$m_user = new M_user();

		if ($_POST['rowid']) {
			$id = $_POST['rowid'];
			$user = $m_user->where('id', $id)->first();
			$data = ['a' => $user];
			echo view('admin/mhs/part-mhs-mod-switch', $data);
		}
	}

	public function process_input()
	{
		$m_mahasiswa = new M_mahasiswa();
		$fileUploadName = $_FILES["fileUpload"]["name"];
		$fileUploadType = $_FILES['fileUpload']['type'];
		$fileUploadTMP = $_FILES['fileUpload']['tmp_name'];
		$data = array(
			'nim'        => $this->request->getPost('nim'),
			'nama'       => $this->request->getPost('nama'),
			'jenisKelamin' => $this->request->getPost('jenisKelamin'),
			'nik' => $this->request->getPost('nik'),
			'tempatLahir' => $this->request->getPost('tempatLahir'),
			'tanggalLahir' => $this->request->getPost('tanggalLahir'),
			'alamat' => $this->request->getPost('alamat'),
			'email' => $this->request->getPost('email'),
			'kontak' => $this->request->getPost('kontak'),
			'namaIbu' => $this->request->getPost('namaIbu'),
			'kontakIbu' => $this->request->getPost('kontakIbu'),
			'namaAyah' => $this->request->getPost('namaAyah'),
			'kontakAyah' => $this->request->getPost('kontakAyah'),
			'namaWali' => $this->request->getPost('namaWali'),
			'kontakWali' => $this->request->getPost('kontakWali'),
			'foto' => $fileUploadName,
			'userID' => 2
		);
		
		$check = $m_mahasiswa->insert($data);
		// print_r($check);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Mahasiswa Berhasil DiTambahkan',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/mahasiswa/list');

	}
}
