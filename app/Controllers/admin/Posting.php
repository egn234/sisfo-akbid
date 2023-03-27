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

        $fileUploadName = $_FILES["fileUpload"]["name"];
        $fileUploadType = $_FILES['fileUpload']['type'];
        $fileUploadTMP = $_FILES['fileUpload']['tmp_name'];
        $input = $this->validate([
            'fileUpload' => [
                'uploaded[fileUpload]',
                'mime_in[fileUpload,image/jpg,image/jpeg,image/png]',
                'max_size[fileUpload,10024]',
            ]
        ]);

        if (!$input) {
            $alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'File Tidak Sesuai',
					'status' => 'error'
				]
			);
			session()->setFlashdata('notif', $alert);
			return redirect()->to('admin/posting');
        } else {
            $img = $this->request->getFile('fileUpload');
			$newName = $img->getRandomName();
			$img->move('../public/uploads/post', $newName);
            $data = array(
                'judul'       => $this->request->getPost('judul'),
                'deskripsi'       => $this->request->getPost('deskripsi'),
                'attachment'         => $newName,
                'adminID' => session()->get('user_id')
            );

            $check = $m_posting->insert($data);
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Data Posting Berhasil DiTambahkan',
                    'status' => 'success'
                ]
            );

            session()->setFlashdata('notif', $alert);
            return redirect()->to('admin/posting');
        }
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
        $id = $this->request->getPost('idPut');

        $fileUploadName = $_FILES["fileUpload"]["name"];
        $fileUploadType = $_FILES['fileUpload']['type'];
        $fileUploadTMP = $_FILES['fileUpload']['tmp_name'];
        $data = array(
            'judul'       => $this->request->getPost('judul'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'attachment'         => $fileUploadName,
            'adminID' => session()->get('user_id')
        );
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
