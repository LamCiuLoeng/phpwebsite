<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
        $this->user_name = session('user_name');
        $this->display();
    }


    public function ajax_upload(){
        $result = upload_img("imgFile");
        if($result[0] == 0){
            $this->ajaxReturn(array('error' => 0 , 'url' => $result[3]));
        }else{
            $this->ajaxReturn(array('error' => 1,'message' => L('MSGUPLOADFAIL')));
        }
    }


    public function edit_homepage(){
        $this->home_en_content = M('DictObject')->where(array('name' => 'HOME_EN_CONTENT'))->find();
        $this->home_cn_content = M('DictObject')->where(array('name' => 'HOME_CN_CONTENT'))->find();
    	$this->highlight = "ADMINHOME";
        $this->display();
    }

    public function save_edit_homepage(){
        $m = M("DictObject");

        $home_en_content = I('home_en_content',null);
        $home_cn_content = I('home_cn_content',null);
        $m->where(array('name' => 'HOME_EN_CONTENT'))->save(array('value' => $home_en_content));
        $m->where(array('name' => 'HOME_CN_CONTENT'))->save(array('value' => $home_cn_content));
        
        $result = upload_all_img();
        if($result[0] == 0){
            $m->where(array('name' => array('like','HERO_IMAGE_%')))->delete();
            foreach ($result[2] as $index => $file) {
                $m->data(array('name' => 'HERO_IMAGE_'.$index, 'value' => $file['url']))->add();
            }
        }
        $this->success(L('MSGUPDATESUCC'),U('index'));
    }


    public function change_pw(){
        $this->id = session('user_id');
        $this->display();
    }

    public function save_change_pw(){
        $id = I('id',null);
        $oldpw = I('oldpw',null);
        $newpw = I('newpw',null);
        $cnpw = I('cnpw',null);
        if(!$id || !$oldpw || !$newpw || !$cnpw){
            $this->error(L('MSGMISSPARAM'));
        }

        if($newpw != $cnpw){
            $this->error(L('MSGWRONGPARAM'));
        }

        $user = M('User')->where(array('id' => $id))->find();
        if(!$user || is_null($user)){
            $this->error(L('MSGNACCOUNTNOTEXIST'));
        }

        $hashpw = authcode($user['password'],$operation = 'DECODE');
        if($oldpw != $hashpw){
            $this->error(L('MSGWRONGPW'));
        }

        $data['password'] = authcode($newpw);
        M('User')->where(array('id' => $user['id']))->save($data);
        $this->success(L('MSGUPDATESUCC'),U('Index/Index'));
    }
	
}