<?php
namespace Home\Model;
use Think\Model;
/**
 * 
 */
class CategoryModel extends Model {
	protected $fields = array('id', 'name', 'desc','category_id');
    protected $pk     = 'id';
}
