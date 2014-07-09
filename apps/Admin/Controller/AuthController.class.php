<?php
namespace Admin\Controller;
use Think\Controller;
class AuthController extends Controller {
    
    public function login(){
        $this->display();
	}
    
    public function check()
    {
        $User = M('User');
        $map['name'] = I('name',NULL);
        $map['password'] = I('password',NULL);

        if(is_null($map['name']) || is_null($map['password'])){
            $this->error(L('MSGNONAMEPASSWORD'),U('login'));
        }
        
        $user = $User->where($map)->find();
        if(!$user || is_null($user)){
            $this->error(L('MSGNAMEPASSWORDWRONG'),U('login'));
        }else{
            session('login','YES');
            //$this->success('',U('Index/index'));
            $this->redirect('Index/index',NULL,0);
        }
        
    }
    
    
    public function logout()
    {
        if(session('?login')){
            session('login',null); 
        }
        $this->success('',U('login'),2);
    }
    
}