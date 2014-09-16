<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$this->heros = M('DictObject')->where(array('name' => array('like', 'HERO_IMAGE_%')))->order('name')->select();
    	$en_content = M('DictObject')->where(array('name' => 'HOME_EN_CONTENT'))->find();
    	$cn_content = M('DictObject')->where(array('name' => 'HOME_CN_CONTENT'))->find();
    	$this->content = ML($en_content['value'],$cn_content['value']);

		$this->highlight = "HOME";
    	$this->display();
	}
	
	public function page($name="")
	{
		$M = M("PageObject");
		$p = $M->where(array('name'=>$name))->find();
		if(!$p || is_null($p)){
			$this->error(L('PAGENOTEXIST'));
		}
		$this->highlight = $p['name'];
		$this->page = $p;
		$this->display();
	}

	public function test(){
		$pw = I('pw');
		$npw = authcode($pw);
		echo $pw.'<br />'.$npw.'<br />';
		$kpw = authcode($npw,"DECODE");
		echo $kpw.'<br />';
		echo $pw == $kpw;
	}

	public function k(){
		echo authcode(I('m'),$operation="DECODE");
	}
}
		