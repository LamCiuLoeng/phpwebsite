<?php
use Think\Auth;
use Think\Page;


function mynow(){
	return date('Y-m-d H:i:s',time());
}



function mydto(){
	return array(
		'create_time' => mynow(),
		'update_time' => mynow(),
		'active' => 0,
		'create_by_id' => session('user_id'),
		'update_by_id' => session('user_id')
	);
		
}

function mydto_edit(){
	return array(
		'update_time' => mynow(),
		'active' => 0,
		'update_by_id' => session('user_id')
	);
		
}



function authcheck($rule,$uid,$relation='or'){
    
    $auth=new Auth();	
	$type = C('AUTH_CONFIG.AUTH_TYPE');
    return $auth->check($rule,$uid,$type,'url',$relation);
 }


function has_all_rules($rule){
    return authcheck($rule,session('user_id'),'and');
}


function has_any_rules($rule){
    return authcheck($rule,session('user_id'),'or');
}

function in_all_groups(){
    
}

function in_any_groups(){
    
}


function download_file($file){
    if(is_file($file)){
        $length = filesize($file);
        $type = mime_content_type($file);
        $showname =  ltrim(strrchr($file,'/'),'/');
        header("Content-Description: File Transfer");
        header('Content-type: ' . $type);
        header('Content-Length:' . $length);
         if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
             header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
         } else {
             header('Content-Disposition: attachment; filename="' . $showname . '"');
         }
         readfile($file);
         exit;
     } else {
         exit(L('MSGFILENOTEXIST'));
     }
}


function upload_img($name)
{
    $config = array(    
                        //'maxSize'    =>    3145728,    
                        'rootPath'   =>    './Public/',
                        'savePath'   =>    'Upload/',    
                        'saveName'   =>    array('uniqid',''),    
                        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),    
                        'autoSub'    =>    false,    
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
        $result[] = "/Public/Upload/".$info['savename'];
    }
    return $result;
}


function upload_all_img(){
    $config = array(    
                        //'maxSize'    =>    3145728,    
                        'rootPath'   =>    './Public/',
                        'savePath'   =>    'Upload/',    
                        'saveName'   =>    array('uniqid',''),    
                        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),    
                        'autoSub'    =>    false,    
                        'subName'    =>    array('date','Ymd','time'),
                     );
    $upload = new \Think\Upload($config);// 实例化上传类
    if(!file_exists($upload->savePath)){
        mkdir($upload->savePath);
    }    
    $result = array(); 
    $info   =   $upload->upload();
    
    if(!$info) {// 上传错误提示错误信息        
        $result[] = 1;
        $result[] = $upload->getError();    
    }else{// 上传成功     
        $result[] = 0;
        $result[] = NULL;

        $img = array();
        foreach($info as $file){
            $img[] =  array(
                            'path' => $file['rootpath'].$file['savepath'].$file['savename'],
                            'url'  => "/Public/Upload/".$file['savename'],
                             );
        }
        $result[] = $img;

        // $result[] = $info['rootpath'].$info['savepath'].$info['savename'];
        // $result[] = "/Public/Upload/".$info['savename'];
    }
    return $result;
}



function ML($en,$cn)
{
	if(LANG_SET == 'en-us'){
		return $en;
	} 
	if(LANG_SET == 'zh-cn'){
		return $cn;
	} 
	return "";
}



function authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {  
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙  
    $ckey_length = 4;  

    // 密匙  
    $key = md5($key ? $key : C('ENCRYPT_KEY'));
       
    // 密匙a会参与加解密  
    $keya = md5(substr($key, 0, 16));  
    // 密匙b会用来做数据完整性验证  
    $keyb = md5(substr($key, 16, 16));  
    // 密匙c用于变化生成的密文  
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';  
    // 参与运算的密匙  
    $cryptkey = $keya.md5($keya.$keyc);  
    $key_length = strlen($cryptkey);  
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性  
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确  
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
    $string_length = strlen($string);  
    $result = '';  
    $box = range(0, 255);  
    $rndkey = array();  
    // 产生密匙簿  
    for($i = 0; $i <= 255; $i++) {  
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);  
    }  
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度  
    for($j = $i = 0; $i < 256; $i++) {  
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;  
        $tmp = $box[$i];  
        $box[$i] = $box[$j];  
        $box[$j] = $tmp;  
    }  
    // 核心加解密部分  
    for($a = $j = $i = 0; $i < $string_length; $i++) {  
        $a = ($a + 1) % 256;  
        $j = ($j + $box[$a]) % 256;  
        $tmp = $box[$a];  
        $box[$a] = $box[$j];  
        $box[$j] = $tmp;  
        // 从密匙簿得出密匙进行异或，再转成字符  
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
    }  
    if($operation == 'DECODE') {  
        // substr($result, 0, 10) == 0 验证数据有效性  
        // substr($result, 0, 10) - time() > 0 验证数据有效性  
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性  
        // 验证数据有效性，请看未加密明文的格式  
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
            return substr($result, 26);  
        } else {
            return '';  
        }  
    } else {  
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因  
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码  
        return $keyc.str_replace('=', '', base64_encode($result));  
    }  
}



function getMyPage($total,$everpage){
    return new MyPage($total,$everpage);
}


class MyPage{
    public $firstRow; // 起始行数
    public $listRows; // 列表每页显示行数
    public $parameter; // 分页跳转时要带的参数
    public $totalRows; // 总行数
    public $totalPages; // 分页总页面数
    public $rollPage   = 11;// 分页栏每页显示的页数
    public $lastSuffix = true; // 最后一页是否显示总页数

    private $p       = 'p'; //分页参数名
    private $url     = ''; //当前链接URL
    private $nowPage = 1;

    // 分页显示定制
    private $config  = array(
        'header' => '<span class="rows">共 %TOTAL_ROW% 条记录</span>',
        'prev'   => '<<',
        'next'   => '>>',
        'first'  => '1...',
        'last'   => '...%TOTAL_PAGE%',
        'theme'  => '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    );

    /**
     * 架构函数
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows, $listRows=20, $parameter = array()) {
        C('VAR_PAGE') && $this->p = C('VAR_PAGE'); //设置分页参数名称
        /* 基础设置 */
        $this->totalRows  = $totalRows; //设置总记录数
        $this->listRows   = $listRows;  //设置每页显示行数
        $this->parameter  = empty($parameter) ? $_GET : $parameter;
        $this->nowPage    = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
        $this->nowPage    = $this->nowPage>0 ? $this->nowPage : 1;
        $this->firstRow   = $this->listRows * ($this->nowPage - 1);
    }

    /**
     * 定制分页链接设置
     * @param string $name  设置名称
     * @param string $value 设置值
     */
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 生成链接URL
     * @param  integer $page 页码
     * @return string
     */
    private function url($page){
        return str_replace(urlencode('[PAGE]'), $page, $this->url);
    }

    /**
     * 组装分页链接
     * @return string
     */
    public function show() {
        if(0 == $this->totalRows) return '';

        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* 计算分页零时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<li><a href="' . $this->url($up_row) . '">' . $this->config['prev'] . '</a></li>' : '';

        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<li><a href="' . $this->url($down_row) . '">' . $this->config['next'] . '</a></li>' : '';

        //第一页
        $the_first = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = '<li><a href="' . $this->url(1) . '">' . $this->config['first'] . '</a></li>';
        }

        //最后一页
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = '<li><a href="' . $this->url($this->totalPages) . '">' . $this->config['last'] . '</a></li>';
        }

        //数字连接
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
            if(($this->nowPage - $now_cool_page) <= 0 ){
                $page = $i;
            }elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
                $page = $this->totalPages - $this->rollPage + $i;
            }else{
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= '<li><a href="' . $this->url($page) . '">' . $page . '</a></li>';
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 1){
                    //$link_page .= '<span class="current">' . $page . '</span>';
                    $link_page .= '<li class="active"><a href="#">' . $page . '</a></li>';
                }
            }
        }

        //替换分页内容
        $page_str = str_replace(
            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%'),
            array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages),
            $this->config['theme']);
        return "<ul class='pagination'>{$page_str}</ul>";
    }
}



?>
