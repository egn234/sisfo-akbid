<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Admin_filter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
		if(!session()->get('logged_in')){
			$alert = '
				<div class="alert alert-danger text-center mb-4 mt-4 pt-2" role="alert">
					Session habis
				</div>
			';

			session()->setFlashdata('notif_login', $alert);
			return redirect()->to('/');

	    }else{
	    	$flag = session()->get('flag');
	    	$user_type = session()->get('user_type');

	    	if ($flag == 0) {
				$alert = '
					<div class="alert alert-danger text-center mb-4 mt-4 pt-2" role="alert">
						Akun ini sudah tidak aktif
					</div>
				';

				session()->setFlashdata('notif_login', $alert);
				return redirect()->to('/');
	    	}

	    	if ($user_type == 'mahasiswa') {
	    		return redirect()->to('mahasiswa/dashboard');
	    	}

	    	if ($user_type == 'dosen') {
	    		return redirect()->to('dosen/dashboard');
	    	}
	    }        
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}