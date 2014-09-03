<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->hello = L('HELLOWORLD');
    	$this->display();
	}
	
	public function page($name="")
	{
		$M = M("PageObject");
		$p = $M->where(array('name'=>$name))->find();
		if(!$p || is_null($p)){
			$this->error(L('PAGENOTEXIST'));
		}
		$this->page = $p;
		$this->display();
	}
	
}
		