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

		$data = array(
			'kodeMatkul'        => $this->request->getPost('kodeMatkul'),
			'namaMatkul'       => $this->request->getPost('namaMatkul'),
			'deskripsi' => $this->request->getPost('deskripsi'),

		);

		$check = $m_matkul->insert($data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Mata Kuliah Berhasil DiTambahkan',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/matkul');
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
		$data = array(
			'kodeMatkul'        => $this->request->getPost('kodeMatkul'),
			'namaMatkul'       	=> $this->request->getPost('namaMatkul'),
			'deskripsi' 		=> $this->request->getPost('deskripsi')
		);
		$m_matkul->update(['id' => $id], $data);
		$alert = view(
			'partials/notification-alert',
			[
				'notif_text' => 'Data Mata Kuliah Berhasil Di Ubah',
				'status' => 'success'
			]
		);

		session()->setFlashdata('notif', $alert);
		return redirect()->to('admin/matkul');
	}

	// // example xls
	// public function export()
	// {
	// 	$m_matkul = new M_matkul();
	// 	$list_matkul = $m_matkul->select('*')
	// 		->get()
	// 		->getResult();

	// 	$spreadsheet = new Spreadsheet();

	// 	$spreadsheet->setActiveSheetIndex(0)
	// 		->setCellValue('A1', 'Nama')
	// 		->setCellValue('B1', 'Email')
	// 		->setCellValue('C1', 'Tanggal dibuat');

	// 	$column = 2;

	// 	// foreach ($list_matkul as $user) {
	// 	// 	$spreadsheet->setActiveSheetIndex(0)
	// 	// 		->setCellValue('A' . $column, $user['name'])
	// 	// 		->setCellValue('B' . $column, $user['email'])
	// 	// 		->setCellValue('C' . $column, $user['created_at']);

	// 	// 	$column++;
	// 	// }

	// 	$writer = new Xlsx($spreadsheet);
	// 	$filename = date('Y-m-d-His') . '-Data-User';

	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// 	header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
	// 	header('Cache-Control: max-age=0');

	// 	$writer->save('php://output');
	// }

	// // example pdf
	// public function generate()
    // {
	// 	$m_matkul = new M_matkul();
	// 	$data['list_matkul'] = $m_matkul->select('*')
	// 		->get()
	// 		->getResult();
			
    //     $filename = date('y-m-d-H-i-s'). '-test-pdf';

    //     // instantiate and use the dompdf class
    //     $dompdf = new Dompdf();

    //     // load HTML content
    //     $dompdf->loadHtml(view('admin/test_pdf', $data));

    //     // (optional) setup the paper size and orientation
    //     $dompdf->setPaper('A4', 'landscape');

    //     // render html as PDF
    //     $dompdf->render();

    //     // output the generated pdf
    //     $dompdf->stream($filename);
    // }

}
