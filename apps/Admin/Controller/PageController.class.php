<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class PageController extends BaseController {
    public function index(){
        $M = M("PageObject");
        $M->where(array('active' => 0)).order("seq")->select();
        
        $this->display();
    }
    
    public function add(){
        
    }
    
    public function save_add()
    {
        
    }
    
    public function edit()
    {
        
    }
    
    public function save_edit()
    {
        
    }
    
    public function del()
    {
        $id = I('id',null);
        if(!$id || is_null($id)){
            $this->error("没有提供ID！");
        }
                
        $M = M("PageObject");
        $p = $M->where(array('active' => 0 , 'id' => intval($id)))->find();
        if(!$p || is_null($p)){
            $this->error("该记录不存在！");
        }
        
        $tmp['active'] = 1;
        $M->where(array('id' => $p['id']))->save($tmp);
        $this->success('成功删除该页面！',U('Page/index'));
    }
    
}