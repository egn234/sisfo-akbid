<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Login_filter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
	    if(session()->get('logged_in')){
	    	$flag = session()->get('flag');
	    	$user_type = session()->get('user_type');

	    	if ($flag == 0) {
					session_destroy();
					return redirect()->to('/');
	    	}

	    	if ($user_type == 'admin') {
	    		return redirect()->to('admin/dashboard');
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