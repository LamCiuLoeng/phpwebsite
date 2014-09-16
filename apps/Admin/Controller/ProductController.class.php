<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ProductController extends BaseController {
    public function index(){
        $Product = M('Product');
        $cid = I('category_id',null);
        $sql = "
			SELECT p.id as id , p.en_name,p.cn_name ,p.update_time,c.en_name as cen_name, c.cn_name as ccn_name 
			FROM thinkphp_product p, thinkphp_category c
			WHERE p.active = 0 and c.active = 0 and c.id = p.category_id 
        ";

        if($cid){
        	$sql .= " and c.id = ".$cid;
        }
        $sql .= "  ORDER BY p.update_time ";

        $everypage = C('EVERY_PAGE_NUMBER');
        $page = getMyPage(count(M()->query($sql)), $everypage);
        $this->page = $page->show();

        $sql2 = $sql.' limit '.$page->firstRow.','.$page->listRows;
        $this->ps = M()->query($sql2);

        $this->cs = M('Category')->where(array('active' => 0 ))->order("create_time")->select();
        $this->cid = $cid;
        $this->highlight = "ADMINPRODUCT";
        $this->display();
    }
    
   
    public function add()
    {
        $Category = M('Category');
        $this->cs = $Category->where('active = 0')->select();
        $this->highlight = "ADMINPRODUCT";
        $this->display();
    }
    
    public function save_add()
    {
        $data['en_name'] = I('en_name','','stripped');
        $data['cn_name'] = I('cn_name','','stripped');
        $data['en_desc'] = I('en_desc','','stripped');
        $data['cn_desc'] = I('cn_desc','','stripped');
        $data['category_id'] = I('category_id');
        $data['active'] = 0;
        
        $info = upload_img('img');
        
        if($info[0] != 0){
            //echo $info[1];
        }else{
            $data['img'] = $info[3];
        }
        
        $Product = M('Product');
        $Product->data($data)->add();
        $this->success(L('MSGADDSUCC'), U('index'));
    }
    
    
    public function del($id='')
    {
        $Product = M('Product');
        $p = $Product->where('id = '.$id)->find();
        if (is_null($p)) {
            $this->redirect('Product/index','',1,L('RECORDNOTEXIST'));
        }
        $data['active'] = 1;
        $Product->where('id = '.$id)->data($data)->save(); 
        $this->success(L('MSGDELSUCC'), U('index'));
    }



    public function update(){
        $id = I("id",null);
        if(!$id || is_null($id)){
            $this->error(L("MSGNOID"));
        }

        $p = M("Product")->where(array('id' => $id))->find();
        if(!$p || is_null($p)){
            $this->error(L('MSGRECORDNOTEXIST'));
        }

        $this->cs = M("Category")->where(array('active' => 0 ))->select();
        $this->p = $p;
        $this->highlight = "ADMINPRODUCT";
        $this->display();

    }

    public function save_update(){
        $id = I("id",null);
        if(!$id || is_null($id)){
            $this->error(L("MSGNOID"));
        }

        $p = M("Product")->where(array('id' => $id))->find();
        if(!$p || is_null($p)){
            $this->error(L('MSGRECORDNOTEXIST'));
        }

        $data = mydto_edit();
        $data['en_name'] = I('en_name','','stripped');
        $data['cn_name'] = I('cn_name','','stripped');
        $data['en_desc'] = I('en_desc','');
        $data['cn_desc'] = I('cn_desc','');
        $data['category_id'] = I('category_id');

        $info = upload_img('img');
        
        if($info[0] != 0){
            //echo $info[1];
        }else{
            $data['img'] = $info[3];
        }

        M("Product")->where(array('id' => $p['id']))->save($data);
        $this->success(L('MSGUPDATESUCC'), U('Product/Index'));


    }
    
}