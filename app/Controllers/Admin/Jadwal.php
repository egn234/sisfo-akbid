<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_jadwal;
use App\Models\M_user;

class Jadwal extends BaseController
{
    public function index()
    {
        $m_user = new M_user();

		$account = $m_user->getAccount(session()->get('user_id'));

		$data = [
			'title' => 'Daftar Jadwal',
			'usertype' => 'Admin',
			'duser' => $account
		];

		return view('admin/jadwal/list-jadwal', $data);
    }

	public function data_jadwal()
	{
		$m_user = new M_user();
        $m_jadwal = new M_jadwal();
        $account = $m_user->getAccount(session()->get('user_id'));

        $list_jadwal = $m_jadwal->getAllJadwal();
        $data = [
            'title' => 'Daftar Jadwal',
            'usertype' => 'Admin',
            'duser' => $account,
            'list_jadwal' => $list_jadwal
        ];

        return json_encode($data);
	}

    public function add_proc()
    {
        $m_jadwal = new M_jadwal();

        $periodeID = $this->request->getPost('periodeID');
        $matakuliahID = $this->request->getPost('matakuliahID');
        $dosenID = $this->request->getPost('dosenID');
        $ruanganID = $this->request->getPost('ruanganID');
        $startTime = $this->request->getPost('startTime');
        $endTime = $this->request->getPost('endTime');
        $day = $this->request->getPost('day');
        $deskripsi = $this->request->getPost('deskripsi');

        $notif = [];
        $filter = true;

        $cek_dosen = $m_jadwal->select('COUNT(id) AS hitung')
            ->where('periodeID', $periodeID)
            ->where('dosenID', $dosenID)
            ->where('day', $day)
            ->where('flag', 1)
            ->where(
                '("'.$startTime.'" BETWEEN startTime AND endTime
                OR "'. $endTime . '" BETWEEN startTime AND endTime)'
            )
            ->get()->getResult()[0]
            ->hitung;

        $cek_matkul = $m_jadwal->select('COUNT(id) AS hitung')
            ->where('periodeID', $periodeID)
            ->where('matakuliahID', $matakuliahID)
            ->where('day', $day)
            ->where('flag', 1)
            ->where(
                '("'.$startTime.'" BETWEEN startTime AND endTime
                OR "'. $endTime . '" BETWEEN startTime AND endTime)'
            )
            ->get()->getResult()[0]
            ->hitung;
        
        $cek_ruangan = $m_jadwal->select('COUNT(id) AS hitung')
            ->where('periodeID', $periodeID)
            ->where('ruanganID', $ruanganID)
            ->where('day', $day)
            ->where('flag', 1)
            ->where(
                '("'.$startTime.'" BETWEEN startTime AND endTime
                OR "'. $endTime . '" BETWEEN startTime AND endTime)'
            )
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_dosen != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Dosen bentrok dengan jadwal lainnya',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_dosen' => $alert];
            $filter = false;
        }

        if ($cek_matkul != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Mata kuliah bentrok dengan jadwal lainnya',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_matkul' => $alert];
            $filter = false;
        }

        if ($cek_ruangan != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Ruangan bentrok dengan jadwal lainnya',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_ruangan' => $alert];
            $filter = false;
        }

        if ($startTime >= $endTime) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Jam awal tidak boleh lebih dari jam akhir',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_time' => $alert];
            $filter = false;
        }
        
        if ($day == "") {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'belum memilih hari',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_day' => $alert];
            $filter = false;
        }

        if(!$filter){
            session()->setFlashdata($notif);
            return redirect()->back();
        }

        $dataset = [
            'periodeID' => $periodeID,
            'matakuliahID' => $matakuliahID,
            'dosenID' => $dosenID,
            'ruanganID' => $ruanganID,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'day' => $day,
            'deskripsi' => $deskripsi,
        ];

        $m_jadwal->insert($dataset);
        
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'jadwal berhasil ditambah',
                'status' => 'success'
            ]
        );

        $notif += ['notif' => $alert];
        session()->setFlashdata($notif);
        return redirect()->back();
    }

    public function edit_proc()
    {
        $m_jadwal = new M_jadwal();

        $periodeID = $this->request->getPost('periodeID');
        $matakuliahID = $this->request->getPost('matakuliahID');
        $dosenID = $this->request->getPost('dosenID');
        $ruanganID = $this->request->getPost('ruanganID');
        $startTime = $this->request->getPost('startTime');
        $endTime = $this->request->getPost('endTime');
        $day = $this->request->getPost('day');
        $deskripsi = $this->request->getPost('deskripsi');
        $id = $this->request->getPost('idPut');

        $notif = [];
        $filter = true;

        $cek_dosen = $m_jadwal->select('COUNT(id) AS hitung')
            ->where('periodeID', $periodeID)
            ->where('dosenID', $dosenID)
            ->where('day', $day)
            ->where('flag', 1)
            ->where('id != '. $id)
            ->where(
                '("'.$startTime.'" BETWEEN startTime AND endTime
                OR "'. $endTime . '" BETWEEN startTime AND endTime)'
            )
            ->get()->getResult()[0]
            ->hitung;

        $cek_matkul = $m_jadwal->select('COUNT(id) AS hitung')
            ->where('periodeID', $periodeID)
            ->where('matakuliahID', $matakuliahID)
            ->where('day', $day)
            ->where('flag', 1)
            ->where('id != '. $id)
            ->where(
                '("'.$startTime.'" BETWEEN startTime AND endTime
                OR "'. $endTime . '" BETWEEN startTime AND endTime)'
            )
            ->get()->getResult()[0]
            ->hitung;
        
        $cek_ruangan = $m_jadwal->select('COUNT(id) AS hitung')
            ->where('periodeID', $periodeID)
            ->where('ruanganID', $ruanganID)
            ->where('day', $day)
            ->where('flag', 1)
            ->where('id != '. $id)
            ->where(
                '("'.$startTime.'" BETWEEN startTime AND endTime
                OR "'. $endTime . '" BETWEEN startTime AND endTime)'
            )
            ->get()->getResult()[0]
            ->hitung;

        if ($cek_dosen != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Dosen bentrok dengan jadwal lainnya',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_dosen' => $alert];
            $filter = false;
        }

        if ($cek_matkul != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Mata kuliah bentrok dengan jadwal lainnya',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_matkul' => $alert];
            $filter = false;
        }

        if ($cek_ruangan != 0) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Ruangan bentrok dengan jadwal lainnya',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_ruangan' => $alert];
            $filter = false;
        }

        if ($startTime >= $endTime) {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'Jam awal tidak boleh lebih dari jam akhir',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_time' => $alert];
            $filter = false;
        }
        
        if ($day == "") {
            $alert = view(
                'partials/notification-alert',
                [
                    'notif_text' => 'belum memilih hari',
                    'status' => 'warning'
                ]
            );

            $notif += ['notif_day' => $alert];
            $filter = false;
        }

        if(!$filter){
            session()->setFlashdata($notif);
            return redirect()->back();
        }

        $dataset = [
            'periodeID' => $periodeID,
            'matakuliahID' => $matakuliahID,
            'dosenID' => $dosenID,
            'ruanganID' => $ruanganID,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'day' => $day,
            'deskripsi' => $deskripsi,
        ];

        $m_jadwal->set($dataset)->where('id', $id)->update();
        
        $alert = view(
            'partials/notification-alert',
            [
                'notif_text' => 'jadwal berhasil ditambah',
                'status' => 'success'
            ]
        );

        $notif += ['notif' => $alert];
        session()->setFlashdata($notif);
        return redirect()->back();
    }

    public function flag_switch()
	{
		$m_jadwal = new M_jadwal();
		$jadwal_id = $this->request->getPost('id_data');
		$jadwal = $m_jadwal->select('*')
        ->where('id', $jadwal_id)
        ->get()
        ->getResult();
		if ($jadwal[0]->flag == 0) {
			$m_jadwal->where('id', $jadwal_id)->set('flag', '1')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Jadwal Diaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		} elseif ($jadwal[0]->flag == 1) {
			$m_jadwal->where('id', $jadwal_id)->set('flag', '0')->update();
			$alert = view(
				'partials/notification-alert',
				[
					'notif_text' => 'Jadwal Dinonaktifkan',
					'status' => 'success'
				]
			);

			session()->setFlashdata('notif', $alert);
		}
		return redirect()->back();
	}
}