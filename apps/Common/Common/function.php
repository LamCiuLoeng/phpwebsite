<?php
use Think\Auth;



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
         exit('文件已被删除！');
     }
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


?>
