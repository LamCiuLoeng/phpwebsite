<?php
namespace Home\Controller;
use Think\Controller;
class ProductController extends Controller {
    public function index(){
    	$id = I('id',null);
		$p = M("Product")->where(array('active' => 0 ,'id' => intval($id)))->find();
		if(!$p || is_null($p)){
			$this->error(L('PRODUCTNOTEXIST'));
		}
		
		$this->p = $p;
		$this->display();
	}
		
}
    