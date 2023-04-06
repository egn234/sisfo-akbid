<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_mahasiswa;

class Profil extends BaseController
{
    public function process_update()
	{
		$m_mahasiswa = new M_mahasiswa();
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$user = $m_user->select('
			tb_user.username, 
			tb_user.id AS user_id, 
			tb_user.flag AS user_flag,
			tb_user.userType, 
			tb_mahasiswa.*
		')
		->where('tb_user.id', session()->get('user_id'))
		->join('tb_mahasiswa', 'tb_user.id = tb_mahasiswa.userID')
		->get()->getResult()[0];

		$nama = $this->request->getPost('nama');
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

		$dataset_mhs = [
			'nama' => $nama,
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
			'kontakWali' => $kontakWali
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

		if ($foto->isValid())
		{
			// unlink(ROOTPATH . "public/uploads/user/" . $user->username . "/profil_pic/" . $user->foto );
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $user->username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_mhs += ['foto' => $profile_pic];
		}

		$m_mahasiswa->set($dataset_mhs)->where('id', $user->id)->update();

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data User berhasil diubah',
				'status' => 'success'
			]
		);
		
		$dataset_mhs = ['notif' => $alert];
		session()->setFlashdata($dataset_mhs);
		return redirect()->back();
	}

	public function update_pass()
	{
		$m_mahasiswa = new M_mahasiswa();
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$user = $m_user->where('id', session()->get('user_id'))->get()->getResult()[0];

		$password = $this->request->getPost('password') ? $this->request->getPost('password') : $_POST['password'];
		$password2 = $this->request->getPost('password2') ? $this->request->getPost('password2') : $_POST['password2'];

		if($password != $password2){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'Password tidak cocok',
				 	'status' => 'warning'
				]
			);
			
			$notif = ['notif' => $alert];
			session()->setFlashdata($notif);
			return redirect()->back();
		}
		
		$options = [
			'cost' => 12
		];

		$pass_new = password_hash($password, PASSWORD_BCRYPT, $options);
		$m_user->set('password', $pass_new)->where('id', session()->get('user_id'))->update();
		
		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Password berhasil diubah',
				'status' => 'success'
			]
		);
		
		$data = ['notif' => $alert];
		session()->setFlashdata($data);
		return redirect()->back();
	}
	
}
