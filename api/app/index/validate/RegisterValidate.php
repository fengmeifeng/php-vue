<?php
namespace app\index\validate;
use \think\Validate;
use app\index\model\RegisterModel;
class RegisterValidate extends Validate {
	protected $rule = [
		'username' => 'require|max:50|isExist',
		'password' => 'require|max:20|min:6',
		// 邮箱 
		'email'    => 'isEmail',
		// 手机号码验证：regex:1[3-8]{1}[0-9]{9}
		'mobile'   => 'require|mobile|isExistMobile',
		'sex'      => 'in:S,M',
	];
	protected $message = [
		'username.require'     => '用户名不能为空',
		'username.max'         => '用户名最多不能超过30个字符',
		'username.isExist'     => '用户名已存在',
		'password.require'     => '密码不能为空',
		'password.min'         => '密码至少6个字符',
		'password.max'         => '密码不能超过20个字符',
		'email.isEmail'        => '邮箱格式不对',
		'mobile.require'       => '手机号码不能为空',
		'mobile.mobile'        => '手机号码格式不对',
		'mobile.isExistMobile' => '手机号码已存在',
		'sex.in'               => '性别请输入S或者M',
	];
	protected function isExist($value) {
		$model = new RegisterModel;
		$res = $model->getRs(['username'=>$value]);
		if ($res) return false;
		return true;
	}
	protected function isEmail($value) {
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) return false;
		return true;
	}
	protected function isExistMobile($value) {
		$model = new RegisterModel;
		$res = $model->getRs(['mobile'=>$value]);
		if ($res) return false;
		return true;
	}
}
?>