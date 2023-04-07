<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\M_user;
use App\Models\M_posting;

class Posting extends BaseController
{

    public function index()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));
        
        $data = [
            'title' => 'Daftar Posting',
            'usertype' => 'Admin',
            'duser' => $account
        ];

        return view('admin/posting/list-posting', $data);
    }

    // ? Load data into json
    public function data_posting()
    {
        $m_user = new M_user();
        $m_posting = new M_posting();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_posting = $m_posting->select('*')
            ->get()
            ->getResult();
        $data = [
            'title' => 'Daftar Posting',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_posting' => $list_posting
        ];

        return json_encode($data);
    }

    public function process_input()
    {
        $m_posting = new M_posting();
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));
        
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'adminID' => $account->user_id
        ];

        $file = $this->request->getFile('fileUpload');

        if ($file->isValid()) {
            $newName = $file->getRandomName() . '_'. $account->user_id;
			$file->move(ROOTPATH . 'public/uploads/posts/', $newName);
			$attachment = $file->getName();
			$data += ['attachment' => $attachment];
        }

        $m_posting->insert($data);

        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Postingan berhasil dibuat',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->back();
    }

    public function process_delete()
    {
        $m_posting = new M_posting();
        $id = $this->request->getPost('idDel');
        $check = $m_posting->delete(array('id ' => $id));
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Berhasil Dihapus',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/posting');
    }

    public function process_update()
    {
        $m_posting = new M_posting();
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));
        
        $id = $this->request->getPost('idPut');

        $posting = $m_posting->where('id', $id)->get()->getResult()[0];

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        $data = array(
            'judul' => $judul,
            'deskripsi' => $deskripsi
        );

        $file = $this->request->getFile('fileUpload');

        if ($file->isValid()) {
            if ($posting->attachment) {
			    unlink(ROOTPATH . 'public/uploads/posts/' . $posting->attachment );
            }
            $newName = $file->getRandomName() . '_'. $account->user_id;
            $file->move(ROOTPATH . 'public/uploads/posts/', $newName);
			$attachment = $file->getName();
			$data += ['attachment' => $attachment];
        }

        $m_posting->update(['id' => $id], $data);
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'Data Posting Berhasil Di Ubah',
                'status' => 'success'
            ]
        );

        session()->setFlashdata('notif', $alert);
        return redirect()->to('admin/posting');
    }
}
