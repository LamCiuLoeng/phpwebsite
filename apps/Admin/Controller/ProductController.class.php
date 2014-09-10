<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
class ProductController extends BaseController {
    public function index(){
        $Product = M('Product');
        
        $ps = $Product->where("active = 0")->select();
        $this->ps = $ps;
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
        
        $info = $this->upload_img('img');
        
        if($info[0] != 0){
            echo $info[1];
        }else{
            $data['img'] = $info[2];
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
    
    
    private function upload_img($name)
    {
        $config = array(    
                            //'maxSize'    =>    3145728,    
                            'rootPath'   =>    './Public/',
                            'savePath'   =>    'Upload/',    
                            'saveName'   =>    array('uniqid',''),    
                            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),    
                            'autoSub'    =>    true,    
                            'subName'    =>    array('date','Ymd','time'),
                         );
        $upload = new \Think\Upload($config);// 实例化上传类
        if(!file_exists($upload->savePath)){
            mkdir($upload->savePath);
        }    
        $result = array(); 
        $info   =   $upload->uploadOne($_FILES[$name]);  
        
        if(!$info) {// 上传错误提示错误信息        
            $result[] = 1;
            $result[] = $upload->getError();    
        }else{// 上传成功     
            $result[] = 0;
            $result[] = NULL;
            $result[] = $info['rootpath'].$info['savepath'].$info['savename'];
        }
        return $result;
    }


    public function update(){
        
    }
    
}