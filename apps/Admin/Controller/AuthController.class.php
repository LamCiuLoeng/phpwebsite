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
        $name = I('name',NULL);
        $password = I('password',NULL);

        if(is_null($name) || is_null($password)){
            $this->error(L('MSGNONAMEPASSWORD'),U('login'));
        }
        
        $user = $User->where(array('name' => $name))->find();

        if(!$user || is_null($user)){
            $this->error(L('MSGNACCOUNTNOTEXIST'),U('login'));
        }
        elseif ($password != authcode($user['password'],'DECODE')) {
            $this->error(L('MSGWRONGPW'),U('login'));
        }
        else{
            session('login','YES');
            session('user_id', $user['id']);
            session('user_name',$user['name']);
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