<?php

namespace App\Controllers\Admin;

require_once ROOTPATH.'vendor/autoload.php';

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
			'statusAkademik' => 'aktif',
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

	public function process_update($user_id = false)
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
		->where('tb_user.id', $user_id)
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
		$statusAkademik = $this->request->getPost('statusAkademik');

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
			'kontakWali' => $kontakWali,
			'statusAkademik' => $statusAkademik
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
			unlink(ROOTPATH . "public/uploads/user/" . $user->username . "/profil_pic/" . $user->foto );
			$newName = $foto->getRandomName();
			$foto->move(ROOTPATH . 'public/uploads/user/' . $user->username . '/profil_pic/', $newName);
			$profile_pic = $foto->getName();
			$dataset_mhs += ['foto' => $profile_pic];
		}

		$m_mahasiswa->set($dataset_mhs)->where('id', $user->id)->update();

		$alert = view(
			'partials/notification-alert', 
			[
				'notif_text' => 'Data mahasiswa berhasil diubah',
				'status' => 'success'
			]
		);
		
		$dataset_mhs = ['notif' => $alert];
		session()->setFlashdata($dataset_mhs);
		return redirect()->back();
	}

	public function update_pass($iduser = false)
	{
		$m_mahasiswa = new M_mahasiswa();
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

	public function import_mhs()
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
				$m_mahasiswa = new M_mahasiswa();

				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i=2; $i <= $baris; $i++)
				{
					$options = ['cost' => 12];
					$username = $cell->getCell('T'.$i)->getValue();
					$nim = $cell->getCell('B'.$i)->getValue();
					$nama = $cell->getCell('C'.$i)->getValue();
					$jenis_kelamin = $cell->getCell('D'.$i)->getValue();
					$nik = $cell->getCell('E'.$i)->getValue();
					$tempat_lahir = $cell->getCell('F'.$i)->getValue();
					$tanggal_lahir = $cell->getCell('G'.$i)->getValue();
					$alamat = $cell->getCell('H'.$i)->getValue();
					$email = $cell->getCell('I'.$i)->getValue();
					$kontak = $cell->getCell('J'.$i)->getValue();
					$namaIbu = $cell->getCell('K'.$i)->getValue();
					$nikIbu = $cell->getCell('L'.$i)->getValue();
					$kontakIbu = $cell->getCell('M'.$i)->getValue();
					$namaAyah = $cell->getCell('N'.$i)->getValue();
					$nikAyah = $cell->getCell('O'.$i)->getValue();
					$kontakAyah = $cell->getCell('P'.$i)->getValue();
					$namaWali = $cell->getCell('Q'.$i)->getValue();
					$nikWali = $cell->getCell('R'.$i)->getValue();
					$kontakWali = $cell->getCell('S'.$i)->getValue();

					$cek_username = $m_user->select('COUNT(id) as hitung')
						->where('username', $username)
						->get()->getResult()[0]
						->hitung;

					if ($cek_username == 0) {
						$cek_nim = $m_mahasiswa->select('COUNT(id) as hitung')
							->where('nim', $nim)
							->get()->getResult()[0]
							->hitung;
						$cek_nik = $m_mahasiswa->select('COUNT(id) as hitung')
							->where('nik', $nik)
							->get()->getResult()[0]
							->hitung;

						if ($cek_nik == 0 && $cek_nim == 0) {
							$user = [
								'username' => $username,
								'password' => password_hash($username, PASSWORD_BCRYPT, $options),
								'flag' => "1",
								'userType' => 'mahasiswa'
							];
		
							$m_user->insert($user);
							$last_id = $m_user->orderBy('id', 'DESC')->get()->getResult()[0]->id;
							
							helper('filesystem');
							$imgSource = FCPATH . 'assets/images/users/image.jpg';

							mkdir(FCPATH . 'uploads/user/'.$username, 0777);
							mkdir(FCPATH . 'uploads/user/'.$username.'/profil_pic', 0777);
							
							$imgDest = FCPATH . 'uploads/user/'.$username.'/profil_pic/image.jpg';
							copy($imgSource, $imgDest);

							$mahasiswa = [
								'nim' => $nim,
								'nama' => $nama,
								'jenisKelamin' => $jenis_kelamin,
								'nik' => $nik,
								'tempatLahir' => $tempat_lahir,
								'tanggalLahir' => $tanggal_lahir,
								'alamat' => $alamat,
								'email' => $email,
								'kontak' => $kontak,
								'namaIbu' => $namaIbu,
								'nikIbu' => $nikIbu,
								'kontakIbu' => $kontakIbu,
								'namaAyah' => $namaAyah,
								'nikAyah' => $nikAyah,
								'kontakAyah' => $kontakAyah,
								'namaWali' => $namaWali,
								'nikWali' => $nikWali,
								'kontakWali' => $kontakWali,
								'foto' => 'image.jpg',
								'statusAkademik' => 'aktif',
								'userID' => $last_id
							];

							$m_mahasiswa->insert($mahasiswa);
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
