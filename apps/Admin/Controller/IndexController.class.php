<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
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
    	$this->highlight = "ADMINHOME";
        $this->display();
    }

    public function save_edit_homepage(){
        
    }
	
}