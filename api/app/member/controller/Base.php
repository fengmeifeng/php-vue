<?php
namespace app\member\controller;
use think\Controller;
use app\member\controller\Login;
class Base  extends Controller {
	/**
   * 构造方法
   * @author 冯美峰 2020-04-11
   */
  public function __construct() {
  	$login = new Login;
  	$login->check_token();
  }
}
?>