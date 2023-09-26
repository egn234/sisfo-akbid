<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_matkul;
use App\Models\M_prodi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Matakuliah extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		$m_prodi = new M_prodi();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_prodi = $m_prodi->get()->getResult();

		$data = [
			'title' => 'Daftar Mata Kuliah',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_prodi' => $list_prodi
		];

		return view('admin/matkul/list-matkul', $data);
	}

	// ? Load data into json
	public function data_matkul()
	{
		$m_user = new M_user();
		$m_matkul = new M_matkul();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_matkul = $m_matkul->select('*')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Mata Kuliah',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_matkul' => $list_matkul
		];

		return json_encode($data);
	}

	public function process_input()
	{
		$m_matkul = new M_matkul();

		$kodeMatkul = strtoupper((string) $this->request->getPost('kodeMatkul'));
		$namaMatkul = strtoupper((string) $this->request->getPost('namaMatkul'));
		$deskripsi = $this->request->getPost('deskripsi');
		$tingkat = $this->request->getPost('tingkat');
		$semester = $this->request->getPost('semester');
		$sks = $this->request->getPost('sks');
		$prodi = $this->request->getPost('prodi');

		$cek_kode = $m_matkul->select('COUNT(id) AS hitung')
			->where('kodeMatkul', $kodeMatkul)
			->get()->getResult()[0]
			->hitung;

		if ($cek_kode != 0) {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kode matakuliah sudah terdaftar',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
			return redirect()->back();	
		}

		if ($semester == "") {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Semester belum dipilih',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		if ($tingkat == "") {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Tingkat belum dipilih',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		$data = [
			'kodeMatkul' => $kodeMatkul,
			'namaMatkul' => $namaMatkul,
			'deskripsi' => $deskripsi,
			'tingkat' => $tingkat,
			'semester' => $semester,
			'sks' => $sks,
			'prodiID' => $prodi
		];

		$m_matkul->insert($data);

		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Mata kuliah berhasil dibuat',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->back();
	}

	public function process_delete()
	{
		$m_matkul = new M_matkul();
		$id = $this->request->getPost('idDel');
		$check = $m_matkul->delete(array('id ' => $id));
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Berhasil Dihapus',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/matkul');
	}

	public function process_update()
	{
		$m_matkul = new M_matkul();
		$id = $this->request->getPost('idPut');

		$kodeMatkul = strtoupper((string) $this->request->getPost('kodeMatkul'));
		$namaMatkul = strtoupper((string) $this->request->getPost('namaMatkul'));
		$deskripsi = $this->request->getPost('deskripsi');
		$tingkat = $this->request->getPost('tingkat');
		$semester = $this->request->getPost('semester');
		$sks = $this->request->getPost('sks');
		$prodi = $this->request->getPost('prodi');

		$cek_kode = $m_matkul->select('COUNT(id) AS hitung')
			->where('kodeMatkul', $kodeMatkul)
			->where('id !='.$id)
			->get()->getResult()[0]
			->hitung;

		if ($cek_kode != 0) {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kode matakuliah sudah terdaftar',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
			return redirect()->back();	
		}

		if ($semester == "") {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Semester belum dipilih',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		if ($tingkat == "") {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Tingkat belum dipilih',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		$data = [
			'kodeMatkul' => $kodeMatkul,
			'namaMatkul' => $namaMatkul,
			'deskripsi' => $deskripsi,
			'tingkat' => $tingkat,
			'semester' => $semester,
			'sks' => $sks,
			'prodiID' => $prodi
		];

		$m_matkul->set($data)->where('id', $id)->update();

		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Mata kuliah berhasil diubah',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->back();
	}

	public function flag_switch()
	{
		$m_matkul = new M_matkul();
		$matkul_id = $this->request->getPost('id_data');
		$matkul = $m_matkul->where('id', $matkul_id)->first();
		if ($matkul['flag'] == 0) {
			$m_matkul->where('id', $matkul_id)->set('flag', '1')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Mata Kuliah Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($matkul['flag'] == 1) {
			$m_matkul->where('id', $matkul_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Mata Kuliah Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
	}

	public function import_matkul()
	{
		$m_matkul = new M_matkul();
		$m_prodi = new M_prodi();
		
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
			
			$nonExistentProdi = [];

			foreach($spreadsheet->getWorksheetIterator() as $cell)
			{
				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i=2; $i <= $baris; $i++)
				{
					$kodeMatkul = $cell->getCell('B'.$i)->getValue();
					$namaMatkul = strtoupper($cell->getCell('C'.$i)->getValue());
					$prodi = $cell->getCell('D'.$i)->getValue();
					$deskripsi = $cell->getCell('E'.$i)->getValue();
					$tingkat = $cell->getCell('F'.$i)->getValue();
					$semester = $cell->getCell('G'.$i)->getValue();
					$sks = $cell->getCell('H'.$i)->getValue();

					// Check and process "prodi"
					list($strata, $nama_prodi) = explode(' ', $prodi, 2);

					$cek_prodi = $m_prodi->select('COUNT(id) as hitung')
						->where('nama_prodi', $nama_prodi)
						->where('strata', $strata)
						->get()->getResult()[0]
						->hitung;

					if ($cek_prodi == 0) {
						// "prodi" doesn't exist, add it to the error array
						if (!in_array($prodi, $nonExistentProdi)) {
							$nonExistentProdi[] = $prodi;
						}
						$err_count++;
						continue; // Skip this entry
					}

					$cek_kodematkul = $m_matkul->select('COUNT(id) as hitung')
						->where('kodeMatkul', $kodeMatkul)
						->get()->getResult()[0]
						->hitung;

					if ($cek_kodematkul == 0) {
						
						$prodiID = $m_prodi->where('strata', $strata)
							->where('nama_prodi', $nama_prodi)
							->get()->getResult()[0]
							->id;

						$matkul = [
							'kodeMatkul' => $kodeMatkul,
							'namaMatkul' => $namaMatkul,
							'deskripsi' => $deskripsi,
							'tingkat' => $tingkat,
							'semester' => $semester,
							'sks' => $sks,
							'flag' => 1,
							'prodiID' => $prodiID
						];

						$m_matkul->insert($matkul);
						
					}else{
						$err_count++;
					}
					$baris_proc++;
				}
			}
			$total_count = $baris_proc - $err_count;

			if (!empty($nonExistentProdi)) {
				// Generate an error message for nonexistent "prodi" names
				$error_message = 'Error: The following "prodi" names do not exist in the database:<br>';
				
				foreach ($nonExistentProdi as $prodi) {
					$error_message .= '- ' . $prodi . '<br>';
				}
	
				// Include the list of nonexistent "prodi" names in the error message
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
						'notif_text' => 'Berhasil mengimpor beberapa data matakuliah ('.$total_count.' berhasil, '.$err_count.' gagal)',
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
						'notif_text' => 'Gagal mengimpor data matakuliah ('.($total_count).' berhasil, '.$err_count.' gagal)',
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
						'notif_text' => 'Berhasil mengimpor data matakuliah ('.$total_count.' berhasil, '.$err_count.' gagal)',
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
