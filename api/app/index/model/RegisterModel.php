<?php
namespace app\index\model;
use think\Model;
use think\Db;
class RegisterModel extends Model {
	/**
	 * @author 冯美峰 2020-04-15
	 */
	public function __construct() {

	}
	/**
	 * @author 冯美峰 2020-04-15
	 * @param  array $data 注册信息
	 * @return boolean
	 */
	public function registerSave($data) {
		$res = Db::name('user')->insert($data);
		return $res;
	}
	/**
	 * @author 冯美峰 2020-04-15
	 * @param  [array] $where
	 * @return data
	 */
	public function getRs($where, $field='*') {
		$info = Db::name('user')->field($field)->where($where)->find();
		return $info;
	}
}
?>