<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class PageController extends BaseController {
    public function index(){
        $M = M("PageObject");
        $ps = $M->where(array('active' => 0))->select();
        $this->result = $ps;
        $this->highlight = "ADMINPAGE";
        $this->display();
    }
    
    public function add()
    {
    	$this->highlight = "ADMINPAGE";
        $this->display();
    }
    
    public function save_add()
    {
        $m = mydto();
		$m['title'] = I("title",null);
		$m['content'] = I('content',null);
		$M = M("PageObject");
		$M->create($m);
		$id = $M->add();
		$this->success(L('MSGADDSUCC'), U('index'));
    }
    
    public function edit()
    {
        $id = I('id',null);
		if(!$id ||is_null($id)){
			$this->error(L("MSGNOID"));
		}
		
		$M = M("PageObject");
		$p = $M->where(array('id'=> intval($id)))->find();
		if(!$p || is_null($p)){
			$this->error(L('MSGRECORDNOTEXIST'));
		}
		$this->p = $p;
		$this->highlight = "ADMINPAGE";
		$this->display();
    }
		
    
    public function save_edit()
    {
        $id = I('id',null);
		if(!$id ||is_null($id)){
			$this->error(L("MSGNOID"));
		}
		
		$M = M("PageObject");
		$p = $M->where(array('id'=> intval($id)))->find();
		if(!$p || is_null($p)){
			$this->error(L('MSGRECORDNOTEXIST'));
		}
		
		$m = mydto_edit();
		$m['en_title'] = I('en_title',null);
		$m['cn_title'] = I('cn_title',null);
		$m['en_content'] = I('en_content',null);
		$m['cn_content'] = I('cn_content',null);
		$M->where(array('id' => $p['id']))->save($m);
		$this->success(L('MSGUPDATESUCC'), U('index'));
    }
    
    public function del($id)
    {                
        $M = M("PageObject");
        $p = $M->where(array('active' => 0 , 'id' => intval($id)))->find();
        if(!$p || is_null($p)){
            $this->error(L("MSGRECORDNOTEXIST"));
        }
        
        $tmp['active'] = 1;
        $M->where(array('id' => $p['id']))->save($tmp);
        $this->success(L('MSGDELSUCC'),U('Page/index'));
    }
    
}