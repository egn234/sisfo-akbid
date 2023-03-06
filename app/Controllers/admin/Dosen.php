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

	// ? Load data into json
	public function data_dosen()
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

		return json_encode($data);
	}

	public function process_input()
	{
		$m_dosen = new M_dosen();
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
			'userID' => 1
		);

		$check = $m_dosen->insert($data);
		// print_r($check);
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
}
