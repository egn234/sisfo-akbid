<?php

namespace App\Controllers\Admin;

require_once ROOTPATH.'vendor/autoload.php';

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_mahasiswa;
use App\Models\M_nilai;
use App\Models\M_prodi;

class Mahasiswa extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		// $account = $m_user->where('id', session()->get('user_id'))->first();
		$account = $m_user->getAccount(session()->get('user_id'));

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
		$account = $m_user->getAccount(session()->get('user_id'));

		$detail_mhs = $m_user->select('
				tb_user.username, 
				tb_user.id AS user_id, 
				tb_user.flag AS user_flag,
				tb_user.userType, 
				tb_mahasiswa.*,
				tb_prodi.strata,
				tb_prodi.nama_prodi
			')
			->where('tb_user.id', $iduser)
			->join('tb_mahasiswa', 'tb_user.id = tb_mahasiswa.userID')
			->join('tb_prodi', 'tb_prodi.id = tb_mahasiswa.prodiID')
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

	public function data_prodi()
	{
		$m_prodi = new M_prodi();
		$list_prodi = $m_prodi->get()->getResult();

		return $this->response->setJSON($list_prodi);
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
		$nama = is_string($nama) ? strtoupper($nama) : $nama;
		$nim = $this->request->getPost('nim');
		$nik = $this->request->getPost('nik');
		$prodi = $this->request->getPost('prodi');
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
			'userType' => 'mahasiswa',
			'prodiID' => $prodi
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
		
		if($prodi == ""){
			$alert = view(
				'partials/notification-alert', 
				[
					'notif_text' => 'Pilih Prodi terlebih dahulu',
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
		$nama = is_string($nama) ? strtoupper($nama) : $nama;
		$prodi = $this->request->getPost('prodi');
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
			'prodiID' => $prodi,
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
		$m_user = new M_user();
		$m_mahasiswa = new M_mahasiswa();
		$m_prodi = new M_prodi();
		
		$file = $this->request->getFile('file_import');

		if ($file->isValid())
		{
			$ext = $file->guessExtension();
			$filepath = WRITEPATH . 'uploads/' . $file->store();

			if ($ext == 'csv') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} elseif ($ext == 'xls' || $ext == 'xlsx') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$reader->setReadDataOnly(true);
			$reader->setReadEmptyCells(false);
			$spreadsheet = $reader->load($filepath);
			$err_count = 0;
			$baris_proc = 0;

			$nonExistentProdi = [];
			$existingUsernames = [];
			$existingNims = [];
			$existingNiks = [];

			foreach ($spreadsheet->getWorksheetIterator() as $cell) {
				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i = 2; $i <= $baris; $i++) {
					$options = ['cost' => 12];
					$username = $cell->getCell('U'.$i)->getValue();
					$nik = $cell->getCell('E'.$i)->getValue();
					$nim = $cell->getCell('B'.$i)->getValue();
					
					// Check username, nama, and nik
					$usernameCheckResult = $this->checkUsername($username, $m_user, $existingUsernames);
					$nikCheckResult = $this->checkNik($nik, $m_mahasiswa, $existingNiks);
					$nimCheckResult = $this->checkNim($nim, $m_mahasiswa, $existingNims);

					if ($usernameCheckResult === true && $nikCheckResult === true && $nimCheckResult === true) {
						$user = [
							'username' => $username,
							'password' => password_hash($username, PASSWORD_BCRYPT, $options),
							'flag' => "1",
							'userType' => 'mahasiswa'
						];

						$prodi = $cell->getCell('F'.$i)->getValue();

						// Check and process "prodi" names
						$prodiCheckResult = $this->checkAndProcessProdi($prodi, $m_prodi);

						if ($prodiCheckResult === true) {
							$m_user->insert($user);
							$last_id = $m_user->orderBy('id', 'DESC')->get()->getResult()[0]->id;
							
							helper('filesystem');
							$imgSource = FCPATH . 'assets/images/users/image.jpg';

							mkdir(FCPATH . 'uploads/user/'.$username, 0777);
							mkdir(FCPATH . 'uploads/user/'.$username.'/profil_pic', 0777);
							
							$imgDest = FCPATH . 'uploads/user/'.$username.'/profil_pic/image.jpg';
							copy($imgSource, $imgDest);

							list($strata, $nama_prodi) = explode(' ', $prodi, 2);
							$prodiID = $m_prodi->where('strata', $strata)
								->where('nama_prodi', $nama_prodi)
								->get()->getResult()[0]
								->id;

							$mahasiswa = [
								'nim' => $nim,
								'nama' => strtoupper((string) $cell->getCell('C'.$i)->getValue()),
								'jenisKelamin' => $cell->getCell('D'.$i)->getValue(),
								'nik' => $nik,
								'prodiID' => $prodiID,
								'tempatLahir' => $cell->getCell('G'.$i)->getValue(),
								'tanggalLahir' => date('Y-m-d', strtotime($cell->getCell('H'.$i)->getValue())),
								'alamat' => $cell->getCell('I'.$i)->getValue(),
								'email' => $cell->getCell('J'.$i)->getValue(),
								'kontak' => $cell->getCell('K'.$i)->getValue(),
								'namaIbu' => $cell->getCell('L'.$i)->getValue(),
								'nikIbu' => $cell->getCell('M'.$i)->getValue(),
								'kontakIbu' => $cell->getCell('N'.$i)->getValue(),
								'namaAyah' => $cell->getCell('O'.$i)->getValue(),
								'nikAyah' => $cell->getCell('P'.$i)->getValue(),
								'kontakAyah' => $cell->getCell('Q'.$i)->getValue(),
								'namaWali' => $cell->getCell('R'.$i)->getValue(),
								'nikWali' => $cell->getCell('S'.$i)->getValue(),
								'kontakWali' => $cell->getCell('T'.$i)->getValue(),
								'foto' => 'image.jpg',
								'statusAkademik' => 'aktif',
								'userID' => $last_id
							];

							$m_mahasiswa->insert($mahasiswa);
						} else {
							$err_count++;
							// "prodi" doesn't exist, add it to the error array
							if (!in_array($prodiCheckResult, $nonExistentProdi)) {
								$nonExistentProdi[] = $prodiCheckResult;
							}
						}
					} else {
						$err_count++;
					}
					$baris_proc++;
				}
			}
			$total_count = $baris_proc - $err_count;

			if (!empty($nonExistentProdi)) {
				// Generate an error message grouped by "prodi"
				$error_message = 'Error: The following "prodi" names do not exist in the database:<br>';
				
				foreach ($nonExistentProdi as $prodi) {
					$error_message .= '- ' . $prodi . '<br>';
				}
			
				// Create an alert for the error
				$alert = view(
					'partials/notification-alert',
					[
						'notif_text' => $error_message,
						'status' => 'danger'
					]
				);
			
				$data_session = [
					'notif' => $alert
				];
			}
			
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
			
		} else {
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

	// Function to check and process "prodi" names
	private function checkAndProcessProdi($prodi, $m_prodi) {
		list($strata, $nama_prodi) = explode(' ', $prodi, 2);

		// Check if the "prodi" exists in the database
		$cek_prodi = $m_prodi->select('COUNT(id) as hitung')
			->where('nama_prodi', $nama_prodi)
			->where('strata', $strata)
			->get()->getResult()[0]
			->hitung;

		if ($cek_prodi == 0) {
			// Return the non-existent "prodi" for error handling
			return $prodi;
		}

		return true; // "prodi" exists
	}

	// Function to check if username exists
	private function checkUsername($username, $m_user, &$existingUsernames) {
		if (in_array($username, $existingUsernames)) {
			return false; // Username already exists
		}

		$cek_username = $m_user->select('COUNT(id) as hitung')
			->where('username', $username)
			->get()->getResult()[0]
			->hitung;

		if ($cek_username == 0) {
			$existingUsernames[] = $username;
			return true; // Username is unique
		}

		return false; // Username already exists
	}

	// Function to check if NIM exists
	private function checkNim($nim, $m_mahasiswa, &$existingNims) {
		if (in_array($nim, $existingNims)) {
			return false; // NIM already exists
		}

		$cek_nim = $m_mahasiswa->select('COUNT(id) as hitung')
			->where('nim', $nim)
			->get()->getResult()[0]
			->hitung;

		if ($cek_nim == 0) {
			$existingNims[] = $nim;
			return true; // NIM is unique
		}

		return false; // NIM already exists
	}

	// Function to check if NIK exists
	private function checkNik($nik, $m_mahasiswa, &$existingNiks) {
		if (in_array($nik, $existingNiks)) {
			return false; // NIK already exists
		}

		$cek_nik = $m_mahasiswa->select('COUNT(id) as hitung')
			->where('nik', $nik)
			->get()->getResult()[0]
			->hitung;

		if ($cek_nik == 0) {
			$existingNiks[] = $nik;
			return true; // NIK is unique
		}

		return false; // NIK already exists
	}

	public function data_nilai($user_id = false)
    {
        $m_user = new M_user();
        $m_mahasiswa = new M_mahasiswa();
        $m_nilai = new M_nilai();
        
        $mhs_id = $m_mahasiswa->where("userID", $user_id)
            ->get()->getResult()[0]->id;
        
        $data_nilai = $m_nilai->getIndeksNilaiMhs($mhs_id);

        $data = ['data' => $data_nilai];

        return json_encode($data);
    }
}
