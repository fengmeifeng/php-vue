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
    $data = input();
    // dump($data);
    if (empty($data['username'])) return error("请填写用户名");
    if (empty($data['password'])) return error("请填写密码");
    $info = $this->checkLogin($data);
		return is_array($info)?success($info, "登录成功"):error($info);
  }
  // 验证登录
  public function checkLogin($data) {
    $field = 'id,username,name,email,sex,job,time_out';
    $info = $this->model->getRs(["username" => $data['username']], $field);
    if (empty($info)) return "用户不存在";
    $where = [
      "username" => $data['username'],
      "password" => makePassword($data['password']),
    ];
    $pass = $this->model->getRs($where, $field);
    if(empty($pass)) return "密码错误";
    $token = makeToken();
    $time_out = strtotime("+7 days");
    $uinfo = ['time_out' => $time_out, 'token' => $token];
    $res = $this->model->edit(['id'=>$info['id']], $uinfo);
    session('userInfo', $info);
    session('token', $token);
    session('uid', $info['id']);
    $info['token'] = $token;
    return $info;
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
  public function checkToken($token) {
    $res = Db::name($this->table_name)->field('time_out')->where('token', $token)->find();
    if (!empty($res)) {
      //dump(time() - $res[0]['time_out']);
      if (time() - $res['time_out'] > 0) {
        return 90003; // token长时间未使用而过期，需重新登陆
      }
      $new_time_out = time() + 604800; // 604800是七天
      $res = Db::name($this->table_name)->where('token', $token)->update(['time_out' => $new_time_out]);
      if ($res) {
        return 90001; // token验证成功，time_out刷新成功，可以获取接口信息
      }
    }
    return 90002; // token错误验证失败
  }
  public function login_out() {
     //销毁session
    session("userInfo", NULL);
    session("token", NULL);
    return success([], "退出成功");
  }
}
?>