<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;

class Profil extends BaseController
{
    public function process_update()
    {
        $m_dosen = new M_dosen();
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));
		$user = $m_user->select('
			tb_user.username, 
			tb_user.id AS user_id, 
			tb_user.flag AS user_flag,
			tb_user.userType, 
			tb_dosen.*
		')
		->where('tb_user.id', session()->get('user_id'))
		->join('tb_dosen', 'tb_user.id = tb_dosen.userID')
		->get()->getResult()[0];

		$kodeDosen = $this->request->getPost('kodeDosen');
		$nip = $this->request->getPost('nip');
		$nama = $this->request->getPost('nama');
		$jenisKelamin = $this->request->getPost('jenisKelamin');
		$nik = $this->request->getPost('nik');
		$alamat = $this->request->getPost('alamat');
		$email = $this->request->getPost('email');
		$kontak = $this->request->getPost('kontak');

		$dataset_dosen = [
			'nama' => $nama,
			'kodeDosen' => $kodeDosen,
			'nip' => $nip,
			'jenisKelamin' => $jenisKelamin,
			'nik' => $nik,
			'alamat' => $alamat,
			'email' => $email,
			'kontak' => $kontak
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
			
			$dataset_dosen += ['notif' => $alert];
			session()->setFlashdata($dataset_dosen);
			return redirect()->back();
		}

		if ($foto->isValid())
		{
			// unlink(ROOTPATH . "public/uploads/user/" . $user->username . "/profil_pic/" . $user->foto );
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $user->username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_dosen += ['foto' => $profile_pic];
		}

		$m_dosen->set($dataset_dosen)->where('id', $user->id)->update();

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data User berhasil diubah',
				'status' => 'success'
			]
		);
		
		$dataset_dosen = ['notif' => $alert];
		session()->setFlashdata($dataset_dosen);
		return redirect()->back();
    }

	
	
}
