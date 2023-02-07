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

        if($data){
            $pass = $data['password'];
            $check = password_verify($password, $pass);
            if($check){
                $ses_data = [
                    'user_id' => $data['id'],
                    'flag' => $data['flag'],
                    'user_type' => $data['userType'],
                    'logged_in' => true
                ];

                $session->set($ses_data);
					
                if($data['userType'] == 'admin'){
                    return redirect()->to('admin/dashboard');
                    echo session()->get('username');
                }
                elseif($data['userType'] == 'mahasiswa'){
                    return redirect()->to('mahasiswa/dashboard');
                }
                elseif($data['userType'] == 'dosen'){
                    return redirect()->to('dosen/dashboard');
                }
            }else{
                echo 'password salah';
            }
        }else{
            echo 'tidak ada user terdaftar';
        }
    }

    public function logout(){
        session_destroy();
        redirect()->to('/');
    }

    function testing()
    {
        $m_user = new M_user();
        $options =[
            'cost' => 12
        ];
        
        $data = [
            [
                'username' => 'admin001',
                'password' => password_hash('12345678', PASSWORD_BCRYPT, $options),
                'flag' => '1',
                'userType' => 'admin'
            ],
            [
                'username' => 'mhs001',
                'password' => password_hash('12345678', PASSWORD_BCRYPT, $options),
                'flag' => '1',
                'userType' => 'mahasiswa'
            ],
            [
                'username' => 'dosen001',
                'password' => password_hash('12345678', PASSWORD_BCRYPT, $options),
                'flag' => '1',
                'userType' => 'dosen'
            ],
        ];

        for ($i=0; $i < count($data); $i++) { 
            $m_user->insert($data[$i]);
        }
        echo 'success';
    }
}
