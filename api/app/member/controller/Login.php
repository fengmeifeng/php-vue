<?php
namespace app\member\controller;
use app\member\model\Login as uLogin;
use think\Request as qu;
// use think\Session;
class Login {
	protected $model;
	protected $request;
	/**
   * 构造方法
   * @author 冯美峰 2020-04-13
   * @param  string $base_path
   */
  public function __construct() {
      // 公共模型
      $this->model = new uLogin;
      $this->request = new qu;
  }
  public function index() {
  	$this->do_login();
  }
  
  public function do_login() {
  	//判断请求类型是否为 post
  	if (!is_post()) return error("不是POST请求");
    $data = $this->request->param();
    if (empty($data['username'])) return error("请填写用户名");
    if (empty($data['password'])) return error("请填写密码");
    $info = $this->model->checkLogin($data);
		return is_array($info)?success($info):error($info);
  }
  public function check_token() {
    $token = session('token');
    // var_dump($token);
    $res = $this->model->checkToken($token);
    if ($res ==90001) {
      // return success('ok');
    } else if ($res == 90002) {
      return error('token错误验证失败');
    } else if ($res == 90003) {
      return error('token长时间未使用而过期，需重新登陆');
    }
  }
  public function login_out() {
     //销毁session
    session("userInfo", NULL);
    session("token", NULL);
    return success([], "退出成功");
  }
}
?>