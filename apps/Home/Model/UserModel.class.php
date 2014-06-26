<?php
namespace Home\Model;
use Think\Model;
/**
 * 
 */
class UserModel extends Model {
    protected $tablePrefix = 'thinkphp_'; 
	protected $fields = array('id', 'name', 'password','email');
    protected $pk     = 'id';
}
