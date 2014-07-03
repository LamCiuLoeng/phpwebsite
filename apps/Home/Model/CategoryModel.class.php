<?php
namespace Home\Model;
use Think\Model;
/**
 * 
 */
class CategoryModel extends Model {
	protected $fields = array('id', 'name', 'desc','order','active');
    protected $pk     = 'id';
}
