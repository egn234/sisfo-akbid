<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_ruangan;

class Ruangan extends BaseController
{

	public function index()
	{
		$m_user = new M_user();
		$account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Daftar Ruangan',
			'usertype' => 'Admin',
			'duser' => $account
		];

		return view('admin/ruangan/list-ruangan', $data);
	}

	// ? Load data into json
	public function data_ruangan()
	{
		$m_user = new M_user();
		$m_ruangan = new M_ruangan();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_ruangan = $m_ruangan->select('*')
			->get()
			->getResult();
		$data = [
			'title' => 'Daftar Ruangan',
			'usertype' => 'Admin',
			'duser' => $account,
			'list_ruangan' => $list_ruangan
		];

		return json_encode($data);
	}

    public function process_input()
	{
		$m_ruangan = new M_ruangan();
		
		$kodeRuangan = strtoupper((string) $this->request->getPost('kodeRuangan'));
		$namaRuangan = strtoupper((string) $this->request->getPost('namaRuangan'));
		$deskripsi = $this->request->getPost('deskripsi');

		$cek_kode = $m_ruangan->select('COUNT(id) AS hitung')
			->where('kodeRuangan', $kodeRuangan)
			->get()->getResult()[0]
			->hitung;

		if ($cek_kode != 0) {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kode ruangan telah terdaftar',
					'status' => 'warning'
				]
			);
	
			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		$data = [
			'kodeRuangan' => $kodeRuangan,
			'namaRuangan' => $namaRuangan,
			'deskripsi' => $deskripsi,
		];
		
		$m_ruangan->insert($data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Ruangan berhasil dibuat',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->back();
	}

    public function process_delete()
    {
		$m_ruangan = new M_ruangan();
        $id = $this->request->getPost('idDel');
        $check = $m_ruangan->delete(array('id ' => $id));
        $alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Berhasil Dihapus',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/ruangan');
    }

	public function process_update()
	{
		$m_ruangan = new M_ruangan();
		$id = $this->request->getPost('idPut');
		
		$kodeRuangan = strtoupper((string) $this->request->getPost('kodeRuangan'));
		$namaRuangan = strtoupper((string) $this->request->getPost('namaRuangan'));
		$deskripsi = $this->request->getPost('deskripsi');

		$cek_kode = $m_ruangan->select('COUNT(id) AS hitung')
			->where('kodeRuangan', $kodeRuangan)
			->where('id != '. $id)
			->get()->getResult()[0]
			->hitung;

		if ($cek_kode != 0) {
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Kode ruangan telah terdaftar',
					'status' => 'warning'
				]
			);
	
			session()->setFlashdata('notif', $alert);
			return redirect()->back();
		}

		$data = [
			'kodeRuangan' => $kodeRuangan,
			'namaRuangan' => $namaRuangan,
			'deskripsi' => $deskripsi,
		];
		
		$m_ruangan->set($data)->where('id', $id)->update();
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Ruangan berhasil diubah',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->back();
	}

	public function flag_switch()
	{
		$m_ruangan = new M_ruangan();
		$ruangan_id = $this->request->getPost('id_data');
		$ruangan = $m_ruangan->where('id', $ruangan_id)->first();
		if ($ruangan['flag'] == 0) {
			$m_ruangan->where('id', $ruangan_id)->set('flag', '1')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Ruangan Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($ruangan['flag'] == 1) {
			$m_ruangan->where('id', $ruangan_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Ruangan Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
	}

	public function import_ruangan()
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
				$m_ruangan = new M_ruangan();

				$baris = $cell->getHighestRow();
				$kolom = $cell->getHighestColumn();

				for ($i=2; $i <= $baris; $i++)
				{
					$kodeRuangan = $cell->getCell('B'.$i)->getValue();
					$namaRuangan = $cell->getCell('C'.$i)->getValue();
					$deskripsi = $cell->getCell('D'.$i)->getValue();

					$cek_koderuangan = $m_ruangan->select('COUNT(id) as hitung')
						->where('kodeRuangan', $kodeRuangan)
						->get()->getResult()[0]
						->hitung;

					if ($cek_koderuangan == 0) {

						$ruangan = [
							'kodeRuangan' => $kodeRuangan,
							'namaRuangan' => $namaRuangan,
							'deskripsi' => $deskripsi,
							'flag' => 1
						];

						$m_ruangan->insert($ruangan);

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
						'notif_text' => 'Berhasil mengimpor beberapa data ruangan ('.$total_count.' berhasil, '.$err_count.' gagal)',
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
						'notif_text' => 'Gagal mengimpor data ruangan ('.($total_count).' berhasil, '.$err_count.' gagal)',
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
						'notif_text' => 'Berhasil mengimpor data ruangan ('.$total_count.' berhasil, '.$err_count.' gagal)',
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
