<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_rel_dos_matkul_koor;
use App\Models\M_param_nilai;
use App\Models\M_dosen;
use App\Models\M_matkul;

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

        $list_rel_dos_matkul_koor = $m_rel_dos_matkul_koor->select('tb_dosen.kodeDosen, tb_dosen.nama as namaDosen, tb_dosen.nip, tb_matakuliah.kodeMatkul, tb_matakuliah.tingkat, tb_matakuliah.namaMatkul, rel_dos_matkul_koor.id AS idKor')
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
        $m_param_nilai = new M_param_nilai();

        $dosenID = $this->request->getPost('dosenID');
        $matakuliahID = $this->request->getPost('matakuliahID');

        $cek_dupe = $m_rel_dos_matkul_koor->select('COUNT(id) AS hitung')
            ->where('dosenID', $dosenID)
            ->where('matakuliahID', $matakuliahID)
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_dupe != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Plottingan telah terdaftar',
                    'status' => 'warning'
                ]
            );
    
            session()->setFlashdata('notif', $alert);
            return redirect()->back();
        }

        $data = [
            'dosenID' => $dosenID,
            'matakuliahID' => $matakuliahID
        ];

    	$m_rel_dos_matkul_koor->insert($data);
        
        $koorID = $m_rel_dos_matkul_koor
            ->where('dosenID', $dosenID)
            ->where('matakuliahID', $matakuliahID)
            ->get()->getResult()[0]
            ->id;

        $data_param = [
            'paramKehadiran' => 5,
            'paramUTS' => 20,
            'paramUAS' => 25,
            'paramTugas' => 20,
            'paramPraktek' => 30,
            'koorID' => $koorID
        ];

        $m_param_nilai->insert($data_param);

    	$alert = view(
    		'partials/notification-alert',
    		[
    			'notif_text' => 'Koordinator matakuliah berhasil di set',
    			'status' => 'success'
    		]
    	);

    	session()->setFlashdata('notif', $alert);
    	return redirect()->back();
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
    
	public function data_dosen_flag()
	{
		$m_user = new M_user();
		$m_dosen = new M_dosen();
		// $account = $m_user->where('id', session()->get('user_id'))->first();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_dosen = $m_dosen->select('tb_dosen.*, tb_user.flag, rel_dsn_kls.id AS idRelKls , tb_user.username AS username, tb_user.id AS user_id')
			->join('tb_user', 'tb_user.id = tb_dosen.userID', 'left')
			->join('rel_dsn_kls', 'tb_dosen.id = rel_dsn_kls.dosenID', 'left')
			->where('tb_user.flag', '1')
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

    public function data_matkul_flag()
	{
		$m_user = new M_user();
		$m_matkul = new M_matkul();
		$account = $m_user->getAccount(session()->get('user_id'));

		$list_matkul = $m_matkul->select('*')
            ->where('flag', 1)
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
