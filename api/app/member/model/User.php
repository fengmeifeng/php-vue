<?php
namespace app\member\model;
use think\Model;
use think\Db;
class User extends Model {
	protected $table_name = 'user';
  // 自定义初始化
  protected function initialize() {
    // 需要调用`Model`的`initialize`方法
    parent::initialize();
    // TODO:自定义的初始化
  }
	public function getList($where='', $field='*') {
		$info = Db::name($this->table_name)->field($field)->where($where)->select();
	  return $info;
	}
  public function getRs($where='', $field='*') {
    $info = Db::name($this->table_name)->field($field)->where($where)->find();
    return $info;
  }
  /**
   * @author 冯美峰 2020-04-14
   * @param  array $data 一维数组
   * @return string  ID
   */
  public function insertReturnId($data) {
    $insert = Db::name($this->table_name)->insertGetId($data);
    return $insert;
  }
  /**
   * @author 冯美峰 2020-04-14
   * @param  array $data 二维数组
   * @return boolean 
   */
  public function saveAllDate($data) {
    $res = Db::name($this->table_name)->insertAll($data);
    return $res;
  }
  /**
   * @author 冯美峰 2020-04-14
   * @param  [array] $data 
   * @param  [array|string] $where
   * @return boolean
   */
  public function updateDate($data, $where) {
    $res = Db::name($this->table_name)->where($where)->data($data)->update();
    return $res;
  }
}
?>