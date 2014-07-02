<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends Controller {
    public function index(){
        $Product = M('Product');
        
        $ps = $Product->select();
        $this->ps = $ps;
        $this->display();
    }
}