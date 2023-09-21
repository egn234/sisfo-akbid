<?php

namespace App\Controllers;

use App\Models\M_user;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'LOGIN'
        ];
        return view('login-page', $data);
    }

    public function login_proc()
    {
        $session = session();
        $m_user = new M_user();
        $username = $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');
        $data = $m_user->where('username', $username)->first();
        if ($data) {
            $pass = $data['password'];
            $check = password_verify($password, $pass);
            if ($check) {
                $ses_data = [
                    'user_id' => $data['id'],
                    'flag' => $data['flag'],
                    'user_type' => $data['userType'],
                    'logged_in' => true
                ];

                $session->set($ses_data);

                if ($data['userType'] == 'admin') {
                    return redirect()->to('admin/dashboard');
                } elseif ($data['userType'] == 'mahasiswa') {
                    return redirect()->to('mahasiswa/dashboard');
                } elseif ($data['userType'] == 'dosen') {
                    return redirect()->to('dosen/dashboard');
                }
            } else {
                $session = session();
                $session->destroy();
                $data = [
                    'title' => 'LOGIN',
                    'msg' => 'password salah',
                    'error' => true
                ];
                return view('login-page', $data);
            }
        } else {
            $session = session();
            $session->destroy();
            $data = [
                'title' => 'LOGIN',
                'msg' => 'tidak ada user terdaftar',
                'error' => true
            ];
            return view('login-page', $data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        $data = [
            'title' => 'LOGIN'
        ];
        return view('login-page', $data);
    }

    function testing()
    {
        $m_user = new M_user();
        $options = [
            'cost' => 12
        ];

        $data = [
            [
                'username' => 'administrator',
                'password' => password_hash('administrator', PASSWORD_BCRYPT, $options),
                'flag' => '1',
                'userType' => 'admin'
            ]
        ];

        for ($i = 0; $i < count($data); $i++) {
            $m_user->insert($data[$i]);
        }
        echo 'success';
    }

    public function Profil()
    {
        $m_user = new M_user();
        $account = $m_user->getAccount(session()->get('user_id'));
        $useType = session()->get('user_type');
        if ($useType == 'admin') {
            $detail_admin = $m_user->select('
				tb_user.username, 
				tb_user.id AS user_id, 
				tb_user.flag AS user_flag,
				tb_user.userType, 
				tb_admin.*
			')
                ->where('tb_user.id', session()->get('user_id'))
                ->join('tb_admin', 'tb_user.id = tb_admin.userID')
                ->get()->getResult();
            $data = [
                'title' => 'Profil',
                'usertype' => $useType,
                'duser' => $account,
                'detail_admin' => $detail_admin[0]
            ];
            return view('admin/profil', $data);
        } else if ($useType == 'mahasiswa') {
            $detail_mhs = $m_user->select('
				tb_user.username, 
				tb_user.id AS user_id, 
				tb_user.flag AS user_flag,
				tb_user.userType, 
				tb_mahasiswa.*
			')
                ->where('tb_user.id', session()->get('user_id'))
                ->join('tb_mahasiswa', 'tb_user.id = tb_mahasiswa.userID')
                ->get()->getResult();
            $data = [
                'title' => 'Profil',
                'usertype' => $useType,
                'duser' => $account,
                'detail_mhs' => $detail_mhs[0]
            ];
            return view('mahasiswa/profil', $data);
        } else if ($useType == 'dosen') {

            $detail_dosen = $m_user->select('
				tb_user.username, 
				tb_user.id AS user_id, 
				tb_user.flag AS user_flag,
				tb_user.userType, 
				tb_dosen.*,
                tb_prodi.strata,
                tb_prodi.nama_prodi
			')
                ->where('tb_user.id', session()->get('user_id'))
                ->join('tb_dosen', 'tb_user.id = tb_dosen.userID')
                ->join('tb_prodi', 'tb_prodi.id = tb_dosen.prodiID')
                ->get()->getResult();
            $data = [
                'title' => 'Profil',
                'usertype' => $useType,
                'duser' => $account,
                'detail_dosen' => $detail_dosen[0]
            ];
            return view('dosen/profil', $data);
        }
    }
}
