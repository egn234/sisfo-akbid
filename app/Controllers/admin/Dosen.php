<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;

class Dosen extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		$m_dosen = new M_dosen();
		// $account = $m_user->where('id', session()->get('user_id'))->first();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_dosen = $m_dosen->select('*')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Dosen',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_dosen' => $list_dosen
		];

		return view('admin/dosen/list-dosen', $data);
	}

	public function flag_switch()
	{
		$m_user = new M_user();
		$user_id = $this->request->getPost('user_id');
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

	// ? Load data into json
	public function data_dosen()
	{
		$m_user = new M_user();
		$m_dosen = new M_dosen();
		// $account = $m_user->where('id', session()->get('user_id'))->first();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_dosen = $m_dosen->select('tb_dosen.*, tb_user.username AS username, tb_user.id AS user_id, flag')
			->join('tb_user', 'tb_user.id = tb_dosen.userID')
			->orderBy('tb_dosen.created_at', 'DESC')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Dosen',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_dosen' => $list_dosen
		];

		return json_encode($data);
	}

	public function process_input()
	{
		$m_dosen = new M_dosen();
		$m_user = new M_user();

		$options = [
			'cost' => 12
		];

		$fileUploadName = $_FILES["fileUpload"]["name"];
		$fileUploadType = $_FILES['fileUpload']['type'];
		$fileUploadTMP = $_FILES['fileUpload']['tmp_name'];

		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		$dataUser = array(
			'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT, $options),
			'userType' => 'dosen'
		);
		$idUser = $m_user->insert($dataUser);

		$data = array(
			'kodeDosen'        => $this->request->getPost('kodeDosen'),
			'nip'       => $this->request->getPost('nip'),
			'nama' => $this->request->getPost('nama'),
			'jenisKelamin' => $this->request->getPost('jenisKelamin'),
			'nik' => $this->request->getPost('nik'),
			'alamat' => $this->request->getPost('alamat'),
			'email' => $this->request->getPost('email'),
			'kontak' => $this->request->getPost('kontak'),
			'foto' => $fileUploadName,
			'userID' => $idUser
		);

		$check = $m_dosen->insert($data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Dosen Berhasil DiTambahkan',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/dosen');
	}

	public function process_update()
	{
		$m_dosen = new M_dosen();
		$m_user = new M_user();

		$id = $this->request->getPost('idPut');
		$fileUploadName = $_FILES["fileUpload"]["name"];
		$fileUploadType = $_FILES['fileUpload']['type'];
		$fileUploadTMP = $_FILES['fileUpload']['tmp_name'];
		$data = array(
			'kodeDosen'        => $this->request->getPost('kodeDosen'),
			'nip'       => $this->request->getPost('nip'),
			'nama' => $this->request->getPost('nama'),
			'jenisKelamin' => $this->request->getPost('jenisKelamin'),
			'nik' => $this->request->getPost('nik'),
			'alamat' => $this->request->getPost('alamat'),
			'email' => $this->request->getPost('email'),
			'kontak' => $this->request->getPost('kontak'),
			'foto' => $fileUploadName,
			'userID' => $this->request->getPost('idUser')
		);
		$m_dosen->update(['id' => $id], $data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Mata Kuliah Berhasil Di Ubah',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/mahasiswa/listl');
	}
}
