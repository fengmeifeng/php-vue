<?php
namespace app\menu\model;
use think\Model;
use think\Db;
class MenuModel extends Model {
	public function __construct() {}
	protected $table_name = "sys_menu";
	public function getList($where, $field="*", $pageSize='10', $page='1') {
		$list = Db::name($this->table_name)->field($field)->where($where)->page($page, $pageSize)->select();
		return $list;
	}
	public function getTotal($where) {
		$count = Db::name($this->table_name)->where($where)->count();
		return $count;
	}
	public function add($data) {
		$res = Db::name($this->table_name)->insert($data);
		return $res;
	}
	public function getRs($where, $field='*') {
		$res = Db::name($this->table_name)->field($field)->where($where)->find();
		return $res;
	}
	public function edit($data, $where) {
		$res = Db::name($this->table_name)->where($where)->update($data);
		return $res;
	}
}
?>