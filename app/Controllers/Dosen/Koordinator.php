<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_rel_dos_matkul_koor;
use App\Models\M_param_nilai;

class Koordinator extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

        $account = $m_user->getAccount(session()->get('user_id'));

        $data = [
			'title' => 'Kelola Indeks Nilai',
			'usertype' => session()->get('user_type'),
			'duser' => $account,
        ];
        return view('dosen/koor/list-matkul-koor', $data);
    }

    public function koor_data()
    {
        $m_user = new M_user();
        $m_param_nilai = new M_param_nilai();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_matkul = $m_param_nilai->getParamByDosen($account->user_id);
        $data = [
            'title' => 'Daftar Kordinator Mata Kuliah',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_matkul' => $list_matkul
        ];

        return json_encode($data);
    }

    public function edit_param()
    {
        $m_user = new M_user();
        $m_param_nilai = new M_param_nilai();

        $param_id = $this->request->getPost('rowid');
        $parameter_nilai = $m_param_nilai->where('id', $param_id)->get()->getResult()[0];

        $data = [
            'param_nilai' => $parameter_nilai
        ];

        return view('dosen/koor/part-param-edit', $data);
    }

    public function edit_param_proc()
    {
        $m_param_nilai = new M_param_nilai();
        
        $data = [
            'paramTugas' => $this->request->getPost('paramTugas'),
            'paramPraktek' => $this->request->getPost('paramPraktek'),
            'paramUTS' => $this->request->getPost('paramUTS'),
            'paramUAS' => $this->request->getPost('paramUAS'),
            'paramKehadiran' => $this->request->getPost('paramKehadiran')
        ];

        $m_param_nilai->set($data)->where('id', $this->request->getPost('param_id'))->update();

        $alert = view(
            'partials/notification-alert', 
            [
                'notif_text' => 'Parameter nilai berhasil diubah',
                'status' => 'success'
            ]
        );
        
        $notif = ['notif' => $alert];
        session()->setFlashdata($notif);
        return redirect()->back();
    }
}
