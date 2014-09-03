<?php
namespace Home\Controller;
use Think\Controller;
class CategoryController extends Controller {
    public function index($id){
    	$p = I('p',1);
		$pagenumber = C('EVERY_PAGE_NUMBER');		
        $Category = M('Category');
        
		$category  = M('Category')->where(array('id'=>intval($id)))->find();
		$this->c = $category;
		
        $condition['category_id'] = $id;
        $condition['active'] = 0;
        
        $Product = M('Product');
        $this->ps = $Product->where($condition)->order('en_name')->page($p.','.$pagenumber)->select();;
  		
		$count = $Product->where($condition)->count();
		$Page = new \Think\Page($count,$pagenumber);
		$this->assign('page',$Page->show());
    	$this->display();
	}
}