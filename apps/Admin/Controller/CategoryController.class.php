<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends Controller {
    public function index(){
        $Category = M('Category');
        
        $cs = $Category->where('active = 0')->select();
        $this->cs = $cs;
        $this->display();
    }
    
    public function add()
    {
        $this->display();
    }
    
    public function save_add()
    {
        $data['name'] = I('post.name','','stripped');
        $data['desc'] = I('post.desc','','stripped');
        
        $Category = M('Category');
        $Category->data($data)->add();
        $this->success(L('MSGADDSUCC'), U('index'));
    }
    
    public function update($id='')
    {
        $Category = M('Category');
        $c = $Category->where('id = '.$id)->find();
        if (is_null($c)) {
            $this->redirect('Category/index','',1,L('MSGRECORDNOTEXIST'));
        }
        $this->c = $c; 
        $this->display();
    }
    
    public function save_update()
    {
        $id = I('post.id',null);
        if(is_null($id)){
            $this->redirect('Category/index','',1,L('MSGNOID'));
        }
        
        $data['name'] = I('post.name',null,stripped);
        if(is_null($data['name'])){
            $this->redirect('Category/index','',1,L('MSGNONAME'));
        }
        $data['desc'] = I('post.desc',null,stripped);
        $Category = M('Category');
        $Category->where('id = '.$id)->save($data);
        
        $this->success(L('MSGUPDATESUCC'), U('index'));
    }
    
    
    public function del($id='')
    {
        $Category = M('Category');
        $c = $Category->where('id = '.$id)->find();
        if (is_null($c)) {
            $this->redirect('Category/index','',1,L('RECORDNOTEXIST'));
        }
        $data['active'] = 1;
        $Category->where('id = '.$id)->data($data)->save(); 
        $this->success(L('MSGDELSUCC'), U('index'));
    }
}