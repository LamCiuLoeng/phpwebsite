<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 
 */
class UserController extends Controller {
	
	public function index()
	{
		$User = M('User');
        $this->users = $User->select();
        $this->display();
        
        // $User = M('User');
        // $param['name'] = 'CL.Lamaaa';
        // $param['password'] = 'kk';
        // $User->create($param);
        // $User->add();
        // $this->aa = 'asdfasfd';
        // $this->display();
	}
}
