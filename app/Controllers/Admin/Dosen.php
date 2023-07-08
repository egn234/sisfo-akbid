<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_dosen;
use App\Models\M_rel_dsn_kls;


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

	function data_historiWaldos($id = false){
		$m_user = new M_user();

		$m_rel_dsn_kls = new M_rel_dsn_kls();

		$allData = $m_rel_dsn_kls->getHistoriWaldos($id);
		$data = [
			'data' => $allData
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
		$name = $this->request->getPost('nama');
		$kodeDosen = $this->request->getPost('kodeDosen');
		$nip = $this->request->getPost('nip');
		$nik = $this->request->getPost('nik');
		$jenisKelamin = $this->request->getPost('jenisKelamin');
		$email = $this->request->getPost('email');
		$kontak = $this->request->getPost('kontak');
		$alamat = $this->request->getPost('alamat');
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password') ? $this->request->getPost('password') : $_POST['password'];
		$password2 = $this->request->getPost('password2') ? $this->request->getPost('password2') : $_POST['password2'];

		$dataset_dosen = [
			'nama'=>$name,
			'nip'=>$nip,
			'kodeDosen'=>$kodeDosen,
			'nik'=>$nik,
			'jenisKelamin'=>$jenisKelamin,
			'email'=>$email,
			'kontak'=>$kontak,
			'alamat'=>$alamat,
			'email'=>$email,
			'userType' => 'dosen'
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

		$cek_nik = $m_dosen->where('nik', $nik)->get()->getResult() ? true : false ;
		$cek_nim = $m_dosen->where('nip', $nip)->get()->getResult() ? true : false ;
		$cek_username = $m_user->where('username', $username)->get()->getResult() ? true : false ;

		if($cek_nik){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'NIK telah terdaftar',
				 	'status' => 'warning'
				]
			);
			
			$dataset_dosen += ['notif' => $alert];
			session()->setFlashdata($dataset_dosen);
			return redirect()->back();
		}

		if($cek_nim){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'NIP telah terdaftar',
				 	'status' => 'warning'
				]
			);
			
			$dataset_dosen += ['notif' => $alert];
			session()->setFlashdata($dataset_dosen);
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
			
			$dataset_dosen += ['notif' => $alert];
			session()->setFlashdata($dataset_dosen);
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
			
			$dataset_dosen += ['notif' => $alert];
			session()->setFlashdata($dataset_dosen);
			return redirect()->back();
		}
		$dataset_user = [
			'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT, $options),
			'flag' => "1",
			'userType' => 'dosen'
		];
		$m_user->insert($dataset_user);
		$iduser = $m_user->where('username', $username)->get()->getResult()[0]->id;
		$dataset_dosen += ['userID' => $iduser];

		if($foto->isValid()){
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_dosen += ['foto' => $profile_pic];
		}else{
			helper('filesystem');
			$imgSource = FCPATH . 'assets/images/users/image.jpg';

			mkdir(FCPATH . 'uploads/user/'.$username, 0777);
			mkdir(FCPATH . 'uploads/user/'.$username.'/profil_pic', 0777);
			
			$imgDest = FCPATH . 'uploads/user/'.$username.'/profil_pic/image.jpg';
			copy($imgSource, $imgDest);
			$dataset_dosen += ['foto' => 'image.jpg'];
		}
		$m_dosen->insert($dataset_dosen);

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data dosen berhasil dibuat',
				'status' => 'success'
			]
		);
		
		$dataset_mhs = ['notif' => $alert];
		session()->setFlashdata($dataset_mhs);
		return redirect()->back();
		
	}

	public function update_pass($iduser = false)
	{
		$m_dosen = new M_dosen();
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$user = $m_user->where('id', $iduser)->get()->getResult()[0];

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
		$m_user->set('password', $pass_new)->where('id', $iduser)->update();
		
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

	public function process_update($user_id = false)
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
		->where('tb_user.id', $user_id)
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
			unlink(ROOTPATH . "public/uploads/user/" . $user->username . "/profil_pic/" . $user->foto );
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $user->username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_dosen += ['foto' => $profile_pic];
		}

		$m_dosen->set($dataset_dosen)->where('id', $user->id)->update();

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data dosen berhasil diubah',
				'status' => 'success'
			]
		);
		
		$dataset_dosen = ['notif' => $alert];
		session()->setFlashdata($dataset_dosen);
		return redirect()->back();
	}

	public function detail($iduser = false)
	{
		$m_user = new M_user();
		$m_dosen = new M_dosen();
		$account = $m_user->getAccount(session()->get('user_id'));

		$detail_dosen = $m_user->select('
				tb_user.username, 
				tb_user.id AS user_id, 
				tb_user.flag AS user_flag,
				tb_user.userType, 
				tb_dosen.*
			')
			->where('tb_user.id', $iduser)
			->join('tb_dosen', 'tb_user.id = tb_dosen.userID')
			->get()->getResult();

		$data = [
			'title' => 'Detail Dosen',
			'usertype' => 'Admin',
			'duser' => $account,
			'detail_dosen' => $detail_dosen[0]
		];

		// print_r($detail_dosen[0]);
		// print_r($data);
		return view('admin/dosen/detail-dosen', $data);
	}

	public function import_dosen()
	{
		$file = $this->request->getFile('file_import');

		if ($file->isValid())
		{
			$ext = $file->guessExtension();
			$filepath = WRITEPATH . 'uploads/' . $file->store();

			if ($ext == 'csv') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			}elseif($ext == 'xls' || $ext == 'xlsx') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$reader->setReadDataOnly(true);
			$reader->setReadEmptyCells(false);
			$spreadsheet = $reader->load($filepath);
			$err_count = 0;
			$baris_proc = 0;
			foreach($spreadsheet->getWorksheetIterator() as $cell)
			{
				$m_user = new M_user();
				$m_dosen = new M_dosen();

				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i=2; $i <= $baris; $i++)
				{

					$options = ['cost' => 12];
					$username = $cell->getCell('J'.$i)->getValue();
					$nip = $cell->getCell('C'.$i)->getValue();
					$nama = $cell->getCell('D'.$i)->getValue();
					$jenis_kelamin = $cell->getCell('E'.$i)->getValue();
					$nik = $cell->getCell('F'.$i)->getValue();
					$alamat = $cell->getCell('G'.$i)->getValue();
					$email = $cell->getCell('H'.$i)->getValue();
					$kontak = $cell->getCell('I'.$i)->getValue();
					$kodeDosen = $cell->getCell('B'.$i)->getValue();

					$cek_username = $m_user->select('COUNT(id) as hitung')
						->where('username', $username)
						->get()->getResult()[0]
						->hitung;

					if ($cek_username == 0) {

						$cek_nip = $m_dosen->select('COUNT(id) as hitung')
							->where('nip', $nip)
							->get()->getResult()[0]
							->hitung;
						$cek_nik = $m_dosen->select('COUNT(id) as hitung')
							->where('nik', $nik)
							->get()->getResult()[0]
							->hitung;

						if ($cek_nik == 0 && $cek_nip == 0) {
							$user = [
								'username' => $username,
								'password' => password_hash($username, PASSWORD_BCRYPT, $options),
								'flag' => "1",
								'userType' => 'dosen'
							];
		
							$m_user->insert($user);
							$last_id = $m_user->orderBy('id', 'DESC')->get()->getResult()[0]->id;
							
							helper('filesystem');
							$imgSource = FCPATH . 'assets/images/users/image.jpg';

							mkdir(FCPATH . 'uploads/user/'.$username, 0777);
							mkdir(FCPATH . 'uploads/user/'.$username.'/profil_pic', 0777);
							
							$imgDest = FCPATH . 'uploads/user/'.$username.'/profil_pic/image.jpg';
							copy($imgSource, $imgDest);

							$dosen = [
								'nip' => $nip,
								'nama' => $nama,
								'jenisKelamin' => $jenis_kelamin,
								'nik' => $nik,
								'alamat' => $alamat,
								'email' => $email,
								'kontak' => $kontak,
								'foto' => 'image.jpg',
								'kodeDosen'=> $kodeDosen,
								'userID' => $last_id
							];

							$m_dosen->insert($dosen);
						}else{
							$err_count++;
						}
					}else{
						$err_count++;
					}
					$baris_proc++;
				}
			}
			$total_count = $baris_proc - $err_count;

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
			
		}else {
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
}
