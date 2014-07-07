<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends Controller {
    public function index(){
        $Product = M('Product');
        
        $ps = $Product->where("active = 0")->select();
        $this->ps = $ps;
        $this->display();
    }
    
    public function add()
    {
        $Category = M('Category');
        $this->cs = $Category->where('active = 0')->select();
        $this->display();
    }
    
    public function save_add()
    {
        $data['name'] = I('post.name','','stripped');
        $data['desc'] = I('post.desc','','stripped');
        $data['category_id'] = I('post.category_id');
        
        $info = $this->upload_img('img');
        
        if($info[0] != 0){
            echo $info[1];
        }else{
            echo $info[2];
        }
//         
        // $Product = M('Product');
        // $Product->data($data)->add();
        // $this->success(L('MSGADDSUCC'), U('index'));
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
                            'savePath'   =>    './Public/Uploadsaa/',    
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
        echo $info['savepath'];  
        if(!$info) {// 上传错误提示错误信息        
            $result[] = 1;
            $result[] = $upload->getError();    
        }else{// 上传成功     
            $result[] = 0;
            $result[] = NULL;
            $result[] = $info['savepath'].$info['savename'];
        }
        return $result;
    }
    
}