<?php
namespace app\menu\validate;
use think\Validate;
use app\menu\model\MenuModel;
class MenuValidate extends Validate {
	protected $model;
	public function __construct() {
		$this->model = new MenuModel;
	}
	protected $rule = [
		'name' => 'require|max:40', // |isExist
		'path' => 'require',
	];
	protected $message = [
		'name.require' => '请填写栏目名称',
		'name.max'     => '栏目名称最多40个字符',
		// 'name.isExist' => '栏目名称已经存在',
		'path.require' => '地址必填',
	];
	// public function isExist($value) {
	// 	$res = $this->model->getRs(['name'=>$value], 'name');
	// 	if(!empty($res)) return false;
	// 	return true;
	// }
}
?>