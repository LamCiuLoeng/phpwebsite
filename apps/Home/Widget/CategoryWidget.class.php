<?php
    namespace Home\Widget;
    use Think\Controller;
    /**
     * 
     */
    class CategoryWidget extends Controller {
        
        public function hmenu() {
            $cs = $this->data();
            $this->assign('cs',$cs);
            $this->display('Widget/Category:hmenu');
        }
        
        public function vmenu()
        {
            
        }
        
        protected function data()
        {
            $Cate = M('Category');
            $cs = $Cate->select();
            return $cs;
        }
    }
    