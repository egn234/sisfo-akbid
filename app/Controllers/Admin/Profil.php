<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_admin;

class Profil extends BaseController
{
    public function process_update()
    {
        $m_admin = new M_admin();
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));
        $user = $m_user->select('
			tb_user.username, 
			tb_user.id AS user_id, 
			tb_user.flag AS user_flag,
			tb_user.userType, 
			tb_admin.*
		')
		->where('tb_user.id', session()->get('user_id'))
		->join('tb_admin', 'tb_user.id = tb_admin.userID')
		->get()->getResult()[0];

		$nama = $this->request->getPost('nama');
		$jenisKelamin = $this->request->getPost('jenisKelamin');
		$nik = $this->request->getPost('nik');
		$alamat = $this->request->getPost('alamat');
		$email = $this->request->getPost('email');
		$kontak = $this->request->getPost('kontak');

		$dataset_admin = [
			'nama' => $nama,
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
			
			$dataset_admin += ['notif' => $alert];
			session()->setFlashdata($dataset_admin);
			return redirect()->back();
		}

		if ($foto->isValid())
		{
			// unlink(ROOTPATH . "public/uploads/user/" . $user->username . "/profil_pic/" . $user->foto );
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $user->username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_admin += ['foto' => $profile_pic];
		}

		$m_admin->set($dataset_admin)->where('id', $user->id)->update();

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data User berhasil diubah',
				'status' => 'success'
			]
		);
		
		$dataset_admin = ['notif' => $alert];
		session()->setFlashdata($dataset_admin);
		return redirect()->back();
    }
	
}
