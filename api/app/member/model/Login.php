<?php
namespace app\member\model;
use think\Model;
use think\Db;
// use think\Session;
class Login extends Model {
	protected $table_name = 'user';
	/**
	 * @author 冯美峰 2020-04-14
	 * @return [type] [生成token]
	 */
	private function makeToken() {
    $str = md5(uniqid(md5(microtime(true)), true)); // 生成一个不会重复的字符串
    $str = sha1($str); // 加密
    return $str;
  }  
	public function checkLogin($data) {
		$where = [
      "username" => $data['username'],
      "password" => makePassword($data['password']),
		];
		$info = Db::name($this->table_name)->field('id,username,sex,job,token,time_out')->where($where)->find();
		if (empty($info)) {
			return "用户不存在或者密码错误";
		}
		$token = $this->makeToken();
    $time_out = strtotime("+7 days");
    $uinfo = ['time_out' => $time_out, 'token' => $token];
    $res = Db::name($this->table_name)->where(['username'=>$data['username']])->update($uinfo);
    session('userInfo', $info);
    session('token', $token);
    session('uid', $info['id']);
    $info['token'] = $token;
	  return $info;
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
}
?>