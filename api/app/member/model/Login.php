<?php
namespace app\member\model;
use think\Model;
use think\Db;
// use think\Session;
class Login extends Model {
	protected $table_name = 'user';
  public function getRs($where, $field='*') {
    $info = Db::name($this->table_name)->field($field)->where($where)->find();
    return $info;
  }
  public function edit($where, $data) {
    $res = Db::name($this->table_name)->where($where)->update($data);
    return $res;
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