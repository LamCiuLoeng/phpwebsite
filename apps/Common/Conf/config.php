<?php
return array(
	//'配置项'=>'配置值'
	 'db_type'  => 'mysql',
     'db_host'  => 'localhost',
     'db_port'  => '3306',
     'db_name'  => 'thinkphp',
     'DB_CHARSET'=> 'utf8',
     

     'DB_PREFIX' => 'thinkphp_',
     
	 'LANG_SWITCH_ON' => true,
     'LANG_LIST'        => 'en-us,zh-cn', // 允许切换的语言列表 用逗号分隔
     'VAR_LANGUAGE'     => '1',
     'LANG_AUTO_DETECT' => false, // 自动侦测语言 开启多语言功能后有效
     'DEFAULT_LANG' => 'zh-cn',
     // 'DEFAULT_LANG' => 'en-us',
     
     'EVERY_PAGE_NUMBER' => 6,
);