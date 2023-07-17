<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_matkul;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Matakuliah extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Daftar Mata Kuliah',
			'usertype' => 'Admin',
			'duser' => $account
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
			'sks' => $sks
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
			'sks' => $sks
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
				$m_matkul = new M_matkul();

				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i=2; $i <= $baris; $i++)
				{
					$kodeMatkul = $cell->getCell('B'.$i)->getValue();
					$namaMatkul = strtoupper($cell->getCell('C'.$i)->getValue());
					$deskripsi = $cell->getCell('D'.$i)->getValue();
					$tingkat = $cell->getCell('E'.$i)->getValue();
					$semester = $cell->getCell('F'.$i)->getValue();
					$sks = $cell->getCell('G'.$i)->getValue();

					$cek_kodematkul = $m_matkul->select('COUNT(id) as hitung')
						->where('kodeMatkul', $kodeMatkul)
						->get()->getResult()[0]
						->hitung;

					if ($cek_kodematkul == 0) {

						$matkul = [
							'kodeMatkul' => $kodeMatkul,
							'namaMatkul' => $namaMatkul,
							'deskripsi' => $deskripsi,
							'tingkat' => $tingkat,
							'semester' => $semester,
							'sks' => $sks,
							'flag' => 1
						];

						$m_matkul->insert($matkul);
						
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
