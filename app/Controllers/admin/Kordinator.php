<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_rel_dos_matkul_koor;

class Kordinator extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
            'title' => 'Daftar Kordinator Mata Kuliah',
            'usertype' => 'Admin',
            'duser' => $account
        ];

        return view('admin/kordinator/list-kordinator', $data);
    }

    // ? Load data into json
    public function data_kordinator()
    {
        $m_user = new M_user();
        $m_rel_dos_matkul_koor = new M_rel_dos_matkul_koor();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_rel_dos_matkul_koor = $m_rel_dos_matkul_koor->select('tb_dosen.kodeDosen, tb_dosen.nama as namaDosen, tb_dosen.nip, tb_matakuliah.kodeMatkul, tb_matakuliah.namaMatkul, rel_dos_matkul_koor.id AS idKor')
            ->join('tb_dosen', 'tb_dosen.id = rel_dos_matkul_koor.dosenID', 'left')
            ->join('tb_matakuliah', 'tb_matakuliah.id = rel_dos_matkul_koor.matakuliahID', 'left')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Kordinator Mata Kuliah',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_rel_dos_matkul_koor' => $list_rel_dos_matkul_koor
        ];

        return json_encode($data);
    }

    public function process_input()
    {
    	$m_rel_dos_matkul_koor = new M_rel_dos_matkul_koor();

    	$data = array(
    		'dosenID'       => $this->request->getPost('dosenID'),
    		'matakuliahID'       => $this->request->getPost('matakuliahID')

    	);

    	$check = $m_rel_dos_matkul_koor->insert($data);
    	$alert = view(
    		'partials/notification-alert',
    		[
    			'notif_text' => 'Data Ruangan Berhasil DiTambahkan',
    			'status' => 'success'
    		]
    	);

    	session()->setFlashdata('notif', $alert);
    	return redirect()->to('admin/kordinator');

    }

    public function process_delete()
    {
    	$m_rel_dos_matkul_koor = new M_rel_dos_matkul_koor();
        $id = $this->request->getPost('idDel');
        $check = $m_rel_dos_matkul_koor->delete(array('id ' => $id));
        $alert = view(
    		'partials/notification-alert',
    		[
    			'notif_text' => 'Data Berhasil Dihapus',
    			'status' => 'success'
    		]
    	);

    	session()->setFlashdata('notif', $alert);
    	return redirect()->to('admin/kordinator');
    }

    // public function process_update()
    // {
    // 	$m_ruangan = new M_ruangan();
    // 	$id = $this->request->getPost('idPut');
    // 	$data = array(
    // 		'kodeRuangan'       => $this->request->getPost('kodeRuangan'),
    // 		'namaRuangan'       => $this->request->getPost('namaRuangan'),
    // 		'deskripsi' 		=> $this->request->getPost('deskripsi'),
    // 	);
    // 	$m_ruangan->update(['id' => $id],$data);
    // 	$alert = view(
    // 		'partials/notification-alert',
    // 		[
    // 			'notif_text' => 'Data Mata Kuliah Berhasil Di Ubah',
    // 			'status' => 'success'
    // 		]
    // 	);

    // 	session()->setFlashdata('notif', $alert);
    // 	return redirect()->to('admin/ruangan');
    // }

}
