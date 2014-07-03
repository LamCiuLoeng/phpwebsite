<?php
namespace Home\Model;
use Think\Model;
/**
 * 
 */
class CategoryModel extends Model {
	protected $fields = array('id', 'name', 'path','url','type','active');
    protected $pk     = 'id';
}
