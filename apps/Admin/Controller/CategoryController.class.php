<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends Controller {
    public function index(){
        $Category = M('Category');
        
        $cs = $Category->select();
        $this->cs = $cs;
        $this->display();
    }
    
    public function add()
    {
        
    }
    
    public function save_add()
    {
        
    }
    
    public function update($id='')
    {

    }
    
    public function save_update($id='')
    {
        
    }
    
    public function del($id='')
    {
        
    }
}