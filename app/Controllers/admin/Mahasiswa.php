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
			'duser' => $account
		];

		return view('admin/mhs/list-mahasiswa', $data);
	}

	public function detail($iduser = false)
	{
		$m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
		$account = $m_user->getAccount(session()->get('user_id'));

		$detail_mhs = $m_user->select('
				tb_user.username, 
				tb_user.id AS user_id, 
				tb_user.flag AS user_flag,
				tb_user.userType, 
				tb_mahasiswa.*
			')
			->where('tb_user.id', $iduser)
			->join('tb_mahasiswa', 'tb_user.id = tb_mahasiswa.userID')
			->get()->getResult();

		$data = [
			'title' => 'Detail Mahasiswa',
			'usertype' => 'Admin',
			'duser' => $account,
			'detail_mhs' => $detail_mhs[0]
		];

		// return json_encode($data);
		return view('admin/mhs/detail-mahasiswa', $data);
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

	public function data_mhs_flag()
	{
		$m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_mhs = $m_mahasiswa->select('tb_mahasiswa.* , rel_mhs_kls.id as idRelasiKls, tb_user.flag')
			->join('tb_user', 'tb_user.id = tb_mahasiswa.userID', 'left')
			->join('rel_mhs_kls', 'tb_mahasiswa.id = rel_mhs_kls.mahasiswaID', 'left')
			->where('tb_user.flag', '1')
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

	public function process_input()
	{
		$m_mahasiswa = new M_mahasiswa();
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$options = [
			'cost' => 12
		];

		$nama = $this->request->getPost('nama');
		$nim = $this->request->getPost('nim');
		$nik = $this->request->getPost('nik');
		$jenisKelamin = $this->request->getPost('jenisKelamin');
		$tempatLahir = $this->request->getPost('tempatLahir');
		$tanggalLahir = $this->request->getPost('tanggalLahir');
		$alamat = $this->request->getPost('alamat');
		$email = $this->request->getPost('email');
		$kontak = $this->request->getPost('kontak');
		$namaIbu = $this->request->getPost('namaIbu');
		$kontakIbu = $this->request->getPost('kontakIbu');
		$namaAyah = $this->request->getPost('namaAyah');
		$kontakAyah = $this->request->getPost('kontakAyah');
		$namaWali = $this->request->getPost('namaWali');
		$kontakWali = $this->request->getPost('kontakWali');
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password') ? $this->request->getPost('password') : $_POST['password'];
		$password2 = $this->request->getPost('password2') ? $this->request->getPost('password2') : $_POST['password2'];

		$dataset_mhs = [
			'nama' => $nama,
			'nim' => $nim,
			'nik' => $nik,
			'jenisKelamin' => $jenisKelamin,
			'tempatLahir' => $tempatLahir,
			'tanggalLahir' => $tanggalLahir,
			'alamat' => $alamat,
			'email' => $email,
			'kontak' => $kontak,
			'namaIbu' => $namaIbu,
			'kontakIbu' => $kontakIbu,
			'namaAyah' => $namaAyah,
			'kontakAyah' => $kontakAyah,
			'namaWali' => $namaWali,
			'kontakWali' => $kontakWali,
			'userType' => 'mahasiswa'
		];

		$foto = $this->request->getFile('fileUpload');

		if($jenisKelamin == ""){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'Pilih Jenis Kelamin terlebih dahulu',
				 	'status' => 'warning'
				]
			);
			
			$dataset_mhs += ['notif' => $alert];
			session()->setFlashdata($dataset_mhs);
			return redirect()->back();
		}

		$cek_nik = $m_mahasiswa->where('nik', $nik)->get()->getResult() ? true : false ;
		$cek_nim = $m_mahasiswa->where('nim', $nim)->get()->getResult() ? true : false ;
		$cek_username = $m_user->where('username', $username)->get()->getResult() ? true : false ;

		if($cek_nik){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'NIK telah terdaftar',
				 	'status' => 'warning'
				]
			);
			
			$dataset_mhs += ['notif' => $alert];
			session()->setFlashdata($dataset_mhs);
			return redirect()->back();
		}

		if($cek_nim){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'NIM telah terdaftar',
				 	'status' => 'warning'
				]
			);
			
			$dataset_mhs += ['notif' => $alert];
			session()->setFlashdata($dataset_mhs);
			return redirect()->back();
		}

		if($cek_username){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'Username telah terdaftar',
				 	'status' => 'warning'
				]
			);
			
			$dataset_mhs += ['notif' => $alert];
			session()->setFlashdata($dataset_mhs);
			return redirect()->back();
		}

		if($password != $password2){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'Password tidak cocok',
				 	'status' => 'warning'
				]
			);
			
			$dataset_mhs += ['notif' => $alert];
			session()->setFlashdata($dataset_mhs);
			return redirect()->back();
		}

		$dataset_user = [
			'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT, $options),
			'flag' => "1",
			'userType' => 'mahasiswa'
		];

		$m_user->insert($dataset_user);

		$iduser = $m_user->where('username', $username)->get()->getResult()[0]->id;
		$dataset_mhs += ['userID' => $iduser];

		if($foto->isValid()){
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_mhs += ['foto' => $profile_pic];
		}else{
			helper('filesystem');
			$imgSource = FCPATH . 'assets/images/users/image.jpg';

			mkdir(FCPATH . 'uploads/user/'.$username, 0777);
			mkdir(FCPATH . 'uploads/user/'.$username.'/profil_pic', 0777);
			
			$imgDest = FCPATH . 'uploads/user/'.$username.'/profil_pic/image.jpg';
			copy($imgSource, $imgDest);
			$dataset_mhs += ['foto' => 'image.jpg'];
		}

		$m_mahasiswa->insert($dataset_mhs);

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data mahasiswa berhasil dibuat',
				'status' => 'success'
			]
		);
		
		$dataset_mhs = ['notif' => $alert];
		session()->setFlashdata($dataset_mhs);
		return redirect()->back();
	}

	public function process_update()
	{
		$m_mahasiswa = new M_mahasiswa();

		$id = $this->request->getPost('idPut');
		// $fileUploadName = $_FILES["fileUpload"]["name"];
		// $fileUploadType = $_FILES['fileUpload']['type'];
		// $fileUploadTMP = $_FILES['fileUpload']['tmp_name'];
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
			// 'foto' => $fileUploadName
		);
		$m_mahasiswa->update(['id' => $id], $data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Dosen Berhasil Di Ubah',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/mahasiswa/list');
	}
}
