<?php
namespace Home\Controller;
use Think\Controller;
class CategoryController extends Controller {
    public function index($id){
        $Category = M('Category');
        
        $condition['category_id'] = $id;
        
        
        $Product = M('Product');
        $this->ps = $Product->where($condition)->select();
  
    	$this->display();
	}

}