<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\validate\RegisterValidate;
use think\Request as qu;
use app\index\model\RegisterModel;
class Register extends Base {
	protected $model;
	/**
   * 构造方法
   * @author 冯美峰 2020-04-15
   */
  public function __construct() {
  	$this->model = new RegisterModel;
  }
	/**
	 * @author 冯美峰 2020-04-15
	 * @return 注册
	 */
	public function index() {
		$this->save();
	}
	public function save() {
		if (!is_post()) return error("POST请求");
		$data = $this->check();
		$res = $this->model->registerSave($data);
		if (!$res) return error("注册失败");
		return success(['id'=>$res], "注册成功");
	}
	/**
	 * @author 冯美峰 2020-04-15
	 * @return 验证
	 */
	public function check() {
		$request = new qu();
		$data = $request->param();
		$validate = new RegisterValidate;
    if (!$validate->check($data)) {          
      return error($validate->getError());
    }
    $data['add_time'] = time();
    $data['password'] = makePassword($data['password']);
		return $data;
	} 
} 
?>